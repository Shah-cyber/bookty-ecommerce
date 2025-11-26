<?php

namespace App\Services;

use App\Models\Book;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class RecommendationService
{
    /**
     * Generate hybrid recommendations for a user.
     * Returns a collection of books with a 'score' attribute.
     */
    public function recommendForUser(User $user, int $limit = 12): Collection
    {
        $cacheKey = "reco:user:{$user->id}:v1:{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($user, $limit) {
            $contentScores = $this->contentBasedScores($user);
            $collabScores = $this->collaborativeScores($user);

            // Weighted fusion: content 0.6, collaborative 0.4
            $scores = [];
            foreach ($contentScores as $bookId => $score) {
                $scores[$bookId] = ($scores[$bookId] ?? 0) + (0.6 * $score);
            }
            foreach ($collabScores as $bookId => $score) {
                $scores[$bookId] = ($scores[$bookId] ?? 0) + (0.4 * $score);
            }

            // Fetch books and attach total score
            $bookIds = array_keys($scores);
            $books = Book::with(['genre', 'tropes'])
                ->whereIn('id', $bookIds)
                ->get()
                ->map(function (Book $book) use ($scores) {
                    $book->score = round($scores[$book->id] ?? 0, 4);
                    return $book;
                })
                ->sortByDesc('score')
                ->values();

            return $books->take($limit);
        });
    }

    /**
     * Content-based scoring using genres, tropes, author affinity.
     * Returns [book_id => score].
     */
    protected function contentBasedScores(User $user): array
    {
        // Build user preference profile
        $purchasedBookIds = $this->getPurchasedBookIds($user);
        $wishlistBookIds = $user->wishlistBooks()->pluck('books.id')->all();

        $baseBooks = Book::whereIn('id', array_unique(array_merge($purchasedBookIds, $wishlistBookIds)))
            ->with(['genre', 'tropes'])
            ->get();

        $genreWeights = [];
        $tropeWeights = [];
        $authorWeights = [];

        foreach ($baseBooks as $book) {
            // Higher weight for purchased vs wishlisted
            $weight = in_array($book->id, $purchasedBookIds, true) ? 2.0 : 1.0;
            if ($book->genre) {
                $genreWeights[$book->genre->id] = ($genreWeights[$book->genre->id] ?? 0) + $weight;
            }
            foreach ($book->tropes as $trope) {
                $tropeWeights[$trope->id] = ($tropeWeights[$trope->id] ?? 0) + ($weight * 0.7);
            }
            if (!empty($book->author)) {
                $authorWeights[$book->author] = ($authorWeights[$book->author] ?? 0) + ($weight * 0.5);
            }
        }

        // Normalize weights
        $genreWeights = $this->normalizeVector($genreWeights);
        $tropeWeights = $this->normalizeVector($tropeWeights);
        $authorWeights = $this->normalizeVector($authorWeights);

        // Candidates: books not yet purchased by the user
        $candidates = Book::with(['genre', 'tropes'])
            ->whereNotIn('id', $purchasedBookIds)
            ->where('stock', '>', 0)
            ->get();

        $scores = [];
        foreach ($candidates as $book) {
            $score = 0.0;
            // Genre match
            if ($book->genre && isset($genreWeights[$book->genre->id])) {
                $score += 1.0 * $genreWeights[$book->genre->id];
            }
            // Trope overlap
            foreach ($book->tropes as $trope) {
                if (isset($tropeWeights[$trope->id])) {
                    $score += 0.6 * $tropeWeights[$trope->id];
                }
            }
            // Author affinity
            if (!empty($book->author) && isset($authorWeights[$book->author])) {
                $score += 0.4 * $authorWeights[$book->author];
            }
            // Light popularity boost
            $score += 0.05 * ($book->reviews_count ?? $book->reviews()->count());

            if ($score > 0) {
                $scores[$book->id] = $score;
            }
        }

        return $this->normalizeVector($scores);
    }

    /**
     * Collaborative scoring based on co-purchase behavior.
     * Returns [book_id => score].
     */
    protected function collaborativeScores(User $user): array
    {
        $purchasedBookIds = $this->getPurchasedBookIds($user);
        if (empty($purchasedBookIds)) {
            return [];
        }

        // Find users who bought the same books
        $peerUserIds = OrderItem::query()
            ->whereIn('book_id', $purchasedBookIds)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->where('orders.user_id', '!=', $user->id)
            ->pluck('orders.user_id')
            ->unique()
            ->all();

        if (empty($peerUserIds)) {
            return [];
        }

        // Books purchased by similar users that the current user has not purchased
        $rows = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.user_id', $peerUserIds)
            ->where('orders.status', 'completed')
            ->whereNotIn('order_items.book_id', $purchasedBookIds)
            ->selectRaw('order_items.book_id, COUNT(*) as cnt')
            ->groupBy('order_items.book_id')
            ->orderByDesc('cnt')
            ->limit(200)
            ->get();

        $scores = [];
        foreach ($rows as $row) {
            // Frequency as proxy score
            $scores[(int) $row->book_id] = (float) $row->cnt;
        }

        return $this->normalizeVector($scores);
    }

    /**
     * Recommend books similar to a given book (content-based only).
     */
    public function similarToBook(Book $book, int $limit = 8): Collection
    {
        $cacheKey = "reco:similar:{$book->id}:v1:{$limit}";
        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($book, $limit) {
            $candidates = Book::with(['genre', 'tropes'])
                ->where('id', '!=', $book->id)
                ->where('stock', '>', 0)
                ->get();

            $scores = [];
            foreach ($candidates as $cand) {
                $score = 0.0;
                if ($book->genre && $cand->genre && $book->genre->id === $cand->genre->id) {
                    $score += 1.0;
                }
                $bookTropeIds = $book->tropes->pluck('id')->all();
                $candTropeIds = $cand->tropes->pluck('id')->all();
                $overlap = count(array_intersect($bookTropeIds, $candTropeIds));
                $score += 0.4 * $overlap;
                if (!empty($book->author) && $book->author === $cand->author) {
                    $score += 0.3;
                }
                if ($score > 0) {
                    $scores[$cand->id] = $score;
                }
            }

            $normalized = $this->normalizeVector($scores);
            $books = Book::with(['genre', 'tropes'])
                ->whereIn('id', array_keys($normalized))
                ->get()
                ->map(function (Book $b) use ($normalized) {
                    $b->score = round($normalized[$b->id] ?? 0, 4);
                    return $b;
                })
                ->sortByDesc('score')
                ->values();

            return $books->take($limit);
        });
    }

    /** @return int[] */
    protected function getPurchasedBookIds(User $user): array
    {
        return OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $user->id)
            ->where('orders.status', 'completed')
            ->pluck('order_items.book_id')
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Normalize associative array values to [0..1] by dividing by max.
     */
    protected function normalizeVector(array $vector): array
    {
        if (empty($vector)) {
            return $vector;
        }
        $max = max($vector);
        if ($max <= 0) {
            return $vector;
        }
        foreach ($vector as $k => $v) {
            $vector[$k] = $v / $max;
        }
        return $vector;
    }
}


