<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewHelpful;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewHelpfulController extends Controller
{
    /**
     * Display helpful analytics dashboard.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $search = $request->get('search', '');
        $bookId = $request->get('book_id', '');
        $sort = $request->get('sort', 'helpful_count');
        $period = $request->get('period', 'all'); // all, today, week, month, year

        // Build query for reviews with helpful counts
        $query = Review::with(['book', 'user'])
            ->withCount('helpfuls')
            ->whereHas('helpfuls'); // Only show reviews that have helpful votes

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('book', function($bookQuery) use ($search) {
                      $bookQuery->where('title', 'like', "%{$search}%")
                               ->orWhere('author', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply book filter
        if ($bookId) {
            $query->where('book_id', $bookId);
        }

        // Apply time period filter
        if ($period !== 'all') {
            switch ($period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }

        // Apply sorting
        switch ($sort) {
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'helpful_count':
            default:
                $query->orderBy('helpfuls_count', 'desc');
                break;
        }

        $reviews = $query->paginate(15);

        // Get summary statistics
        $stats = $this->getHelpfulStats($period);

        // Get top books by helpful votes
        $topBooks = $this->getTopBooksByHelpful($period);

        // Get books for filter dropdown
        $books = Book::orderBy('title')->get(['id', 'title', 'author']);

        return view('admin.reviews.helpful.index', compact(
            'reviews',
            'stats',
            'topBooks',
            'books',
            'search',
            'bookId',
            'sort',
            'period'
        ));
    }

    /**
     * Get helpful statistics.
     */
    private function getHelpfulStats($period = 'all')
    {
        $query = ReviewHelpful::query();

        // Apply time period filter
        if ($period !== 'all') {
            switch ($period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }

        $totalHelpfulVotes = $query->count();
        $uniqueReviews = $query->distinct('review_id')->count('review_id');
        $uniqueUsers = $query->distinct('user_id')->count('user_id');

        // Get average helpful votes per review
        $avgHelpfulPerReview = $uniqueReviews > 0 ? round($totalHelpfulVotes / $uniqueReviews, 2) : 0;

        // Get most helpful review
        $mostHelpfulReview = Review::with(['book', 'user'])
            ->withCount('helpfuls')
            ->whereHas('helpfuls')
            ->orderBy('helpfuls_count', 'desc')
            ->first();

        return [
            'total_helpful_votes' => $totalHelpfulVotes,
            'unique_reviews' => $uniqueReviews,
            'unique_users' => $uniqueUsers,
            'avg_helpful_per_review' => $avgHelpfulPerReview,
            'most_helpful_review' => $mostHelpfulReview,
        ];
    }

    /**
     * Get top books by helpful votes.
     */
    private function getTopBooksByHelpful($period = 'all')
    {
        $query = DB::table('review_helpfuls')
            ->join('reviews', 'review_helpfuls.review_id', '=', 'reviews.id')
            ->join('books', 'reviews.book_id', '=', 'books.id')
            ->select('books.id', 'books.title', 'books.author')
            ->selectRaw('COUNT(review_helpfuls.id) as total_helpful')
            ->selectRaw('COUNT(DISTINCT reviews.id) as reviews_count')
            ->groupBy('books.id', 'books.title', 'books.author');

        // Apply time period filter
        if ($period !== 'all') {
            switch ($period) {
                case 'today':
                    $query->whereDate('review_helpfuls.created_at', today());
                    break;
                case 'week':
                    $query->where('review_helpfuls.created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('review_helpfuls.created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('review_helpfuls.created_at', '>=', now()->subYear());
                    break;
            }
        }

        return $query->orderBy('total_helpful', 'desc')
                    ->limit(10)
                    ->get();
    }
}
