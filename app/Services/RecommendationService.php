<?php

namespace App\Services;

use App\Models\Book;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserBookInteraction;
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

        // Use cache tags if available for easier cache clearing
        try {
            $cache = Cache::tags(['recommendations', "user:{$user->id}"]);
            return $cache->remember($cacheKey, now()->addMinutes(30), function () use ($user, $limit) {
                return $this->generateRecommendations($user, $limit);
            });
        } catch (\Exception $e) {
            // Fallback to regular cache if tags not supported
            return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($user, $limit) {
                return $this->generateRecommendations($user, $limit);
            });
        }
    }
    
    /**
     * Generate recommendations without caching (internal method).
     */
    private function generateRecommendations(User $user, int $limit): Collection
    {
        $contentScores = $this->contentBasedScores($user);
        $collabScores = $this->collaborativeScores($user);

        // If user has no data at all (cold-start), use fallback
        if (empty($contentScores) && empty($collabScores)) {
            return $this->fallbackRecommendations($limit);
        }

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
        if (empty($bookIds)) {
            return $this->fallbackRecommendations($limit);
        }

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
    }

    /**
     * Fallback recommendations for cold-start users (no purchases, no interactions).
     * Returns popular/trending books.
     */
    protected function fallbackRecommendations(int $limit): Collection
    {
        return Book::with(['genre', 'tropes'])
            ->where('stock', '>', 0)
            ->orderByDesc('reviews_count')
            ->orderByDesc('created_at')
            ->take($limit)
            ->get()
            ->each(function (Book $book) {
                $book->score = 1.0; // Default score for fallback
            });
    }

    /**
     * Content-based scoring using genres, tropes, author affinity.
     * Now includes implicit feedback (views, clicks, cart) for cold-start users.
     * Returns [book_id => score].
     */
    protected function contentBasedScores(User $user): array
    {
        // Build user preference profile from multiple sources
        $purchasedBookIds = $this->getPurchasedBookIds($user);
        $wishlistBookIds = $user->wishlistBooks()->pluck('books.id')->all();

        // Get interactions (views, clicks, cart) - this helps cold-start users!
        $interactions = UserBookInteraction::where('user_id', $user->id)
            ->whereIn('action', ['view', 'click', 'cart', 'wishlist'])
            ->get()
            ->groupBy('book_id')
            ->map(function ($group) {
                // Aggregate weight: sum of (weight * count) for each interaction
                return $group->sum(function ($interaction) {
                    return $interaction->weight * $interaction->count;
                });
            })
            ->toArray();
        
        $interactionBookIds = array_keys($interactions);

        // Combine all book IDs that indicate user interest
        $allInterestBookIds = array_unique(array_merge(
            $purchasedBookIds,
            $wishlistBookIds,
            $interactionBookIds
        ));

        // If user has NO data at all (cold-start), return empty (fallback handled elsewhere)
        if (empty($allInterestBookIds)) {
            return [];
        }

        $baseBooks = Book::whereIn('id', $allInterestBookIds)
            ->with(['genre', 'tropes'])
            ->get();

        $genreWeights = [];
        $tropeWeights = [];
        $authorWeights = [];

        foreach ($baseBooks as $book) {
            // Determine weight based on action type
            $weight = 0.0;
            
            if (in_array($book->id, $purchasedBookIds, true)) {
                // Purchase: highest weight
                $weight = 5.0;
            } elseif (in_array($book->id, $wishlistBookIds, true)) {
                // Wishlist: high weight
                $weight = 3.0;
            } elseif (isset($interactions[$book->id])) {
                // Interactions: use aggregated weight (already includes count multiplier)
                // Normalize interaction weight to be lower than wishlist but still meaningful
                $weight = min($interactions[$book->id] * 0.3, 2.0); // Cap at 2.0
            }

            if ($weight > 0) {
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
        
        // Use cache tags if available for easier cache clearing
        try {
            $cache = Cache::tags(['recommendations', "book:{$book->id}"]);
            return $cache->remember($cacheKey, now()->addMinutes(30), function () use ($book, $limit) {
                return $this->generateSimilarBooks($book, $limit);
            });
        } catch (\Exception $e) {
            // Fallback to regular cache if tags not supported
            return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($book, $limit) {
                return $this->generateSimilarBooks($book, $limit);
            });
        }
    }
    
    /**
     * Generate similar books without caching (internal method).
     */
    private function generateSimilarBooks(Book $book, int $limit): Collection
    {
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


