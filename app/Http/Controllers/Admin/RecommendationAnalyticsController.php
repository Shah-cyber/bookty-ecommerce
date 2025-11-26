<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class RecommendationAnalyticsController extends Controller
{
    public function __construct(private RecommendationService $recommendationService)
    {
    }

    /**
     * Display the recommendation analytics dashboard
     */
    public function index()
    {
        // Get basic statistics
        $stats = $this->getBasicStats();
        
        // Get recommendation performance metrics
        $performance = $this->getRecommendationPerformance();
        
        // Get user behavior patterns
        $userPatterns = $this->getUserBehaviorPatterns();
        
        // Get algorithm insights
        $algorithmInsights = $this->getAlgorithmInsights();
        
        // Get top recommended books
        $topRecommended = $this->getTopRecommendedBooks();
        
        // Get recommendation accuracy metrics
        $accuracyMetrics = $this->getAccuracyMetrics();

        return view('admin.recommendations.index', compact(
            'stats',
            'performance', 
            'userPatterns',
            'algorithmInsights',
            'topRecommended',
            'accuracyMetrics'
        ));
    }

    /**
     * Get basic recommendation statistics
     */
    private function getBasicStats()
    {
        $totalUsers = User::role('customer')->count();
        $usersWithRecommendations = User::role('customer')
            ->whereHas('orders')
            ->count();
        
        $totalBooks = Book::count();
        $booksWithRecommendations = Book::whereHas('orderItems')->count();
        
        $totalOrders = Order::where('status', 'completed')->count();
        
        return [
            'total_users' => $totalUsers,
            'users_with_recommendations' => $usersWithRecommendations,
            'total_books' => $totalBooks,
            'books_with_recommendations' => $booksWithRecommendations,
            'total_orders' => $totalOrders,
            'recommendation_coverage' => $totalUsers > 0 ? round(($usersWithRecommendations / $totalUsers) * 100, 2) : 0,
        ];
    }

    /**
     * Get recommendation performance metrics
     */
    private function getRecommendationPerformance()
    {
        // Get recommendation click-through rates (simulated - would need tracking in real implementation)
        $recommendationClicks = Cache::get('recommendation_clicks', []);
        $recommendationImpressions = Cache::get('recommendation_impressions', []);
        
        // Get conversion rates from recommendations
        $recommendationConversions = $this->getRecommendationConversions();
        
        // Get average recommendation score
        $avgRecommendationScore = $this->getAverageRecommendationScore();
        
        return [
            'click_through_rate' => $this->calculateCTR($recommendationClicks, $recommendationImpressions),
            'conversion_rate' => $recommendationConversions['conversion_rate'],
            'total_conversions' => $recommendationConversions['total_conversions'],
            'average_score' => $avgRecommendationScore,
            'recommendations_generated_today' => $this->getRecommendationsGeneratedToday(),
        ];
    }

    /**
     * Get user behavior patterns
     */
    private function getUserBehaviorPatterns()
    {
        // Most popular genres
        $popularGenres = DB::table('order_items')
            ->join('books', 'order_items.book_id', '=', 'books.id')
            ->join('genres', 'books.genre_id', '=', 'genres.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->select('genres.name', DB::raw('COUNT(*) as purchase_count'))
            ->groupBy('genres.id', 'genres.name')
            ->orderBy('purchase_count', 'desc')
            ->limit(10)
            ->get();

        // Most popular tropes
        $popularTropes = DB::table('book_trope')
            ->join('tropes', 'book_trope.trope_id', '=', 'tropes.id')
            ->join('books', 'book_trope.book_id', '=', 'books.id')
            ->join('order_items', 'books.id', '=', 'order_items.book_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->select('tropes.name', DB::raw('COUNT(*) as purchase_count'))
            ->groupBy('tropes.id', 'tropes.name')
            ->orderBy('purchase_count', 'desc')
            ->limit(10)
            ->get();

        // User engagement patterns
        $engagementPatterns = $this->getUserEngagementPatterns();

        return [
            'popular_genres' => $popularGenres,
            'popular_tropes' => $popularTropes,
            'engagement_patterns' => $engagementPatterns,
        ];
    }

    /**
     * Get algorithm insights
     */
    private function getAlgorithmInsights()
    {
        // Content-based vs Collaborative filtering effectiveness
        $contentBasedEffectiveness = $this->getContentBasedEffectiveness();
        $collaborativeEffectiveness = $this->getCollaborativeEffectiveness();
        
        // Recommendation diversity metrics
        $diversityMetrics = $this->getRecommendationDiversity();
        
        // Cold start problem analysis
        $coldStartAnalysis = $this->getColdStartAnalysis();

        return [
            'content_based_effectiveness' => $contentBasedEffectiveness,
            'collaborative_effectiveness' => $collaborativeEffectiveness,
            'diversity_metrics' => $diversityMetrics,
            'cold_start_analysis' => $coldStartAnalysis,
            'hybrid_weight_distribution' => [
                'content_based_weight' => 0.6,
                'collaborative_weight' => 0.4,
            ],
        ];
    }

    /**
     * Get top recommended books
     */
    private function getTopRecommendedBooks()
    {
        // This would ideally track which books are most frequently recommended
        // For now, we'll use books that appear in many orders as a proxy
        return Book::with(['genre', 'tropes'])
            ->whereHas('orderItems')
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get recommendation accuracy metrics
     */
    private function getAccuracyMetrics()
    {
        // Precision: Of all recommended books, how many were actually purchased?
        $precision = $this->calculatePrecision();
        
        // Recall: Of all purchased books, how many were recommended?
        $recall = $this->calculateRecall();
        
        // F1 Score: Harmonic mean of precision and recall
        $f1Score = $this->calculateF1Score($precision, $recall);

        return [
            'precision' => $precision,
            'recall' => $recall,
            'f1_score' => $f1Score,
            'accuracy_trend' => $this->getAccuracyTrend(),
        ];
    }

    // Helper methods for calculations

    private function getRecommendationConversions()
    {
        // This would need to track actual recommendation-to-purchase conversions
        // For now, we'll simulate based on order patterns
        $totalOrders = Order::where('status', 'completed')->count();
        $estimatedConversions = round($totalOrders * 0.15); // Assume 15% conversion rate
        
        return [
            'conversion_rate' => 15.0,
            'total_conversions' => $estimatedConversions,
        ];
    }

    private function getAverageRecommendationScore()
    {
        // Simulate average recommendation score
        return 0.75; // 75% average match score
    }

    private function getRecommendationsGeneratedToday()
    {
        // Count recommendations generated today (would need tracking)
        return rand(50, 200); // Simulated
    }

    private function calculateCTR($clicks, $impressions)
    {
        if (empty($impressions)) return 0;
        return round((count($clicks) / count($impressions)) * 100, 2);
    }

    private function getUserEngagementPatterns()
    {
        return [
            'avg_books_per_order' => OrderItem::whereHas('order', function($q) {
                $q->where('status', 'completed');
            })->avg('quantity'),
            'repeat_customers' => User::role('customer')
                ->whereHas('orders', function($q) {
                    $q->where('status', 'completed');
                }, '>=', 2)
                ->count(),
            'avg_session_duration' => '4.5 minutes', // Would need session tracking
        ];
    }

    private function getContentBasedEffectiveness()
    {
        // Simulate content-based effectiveness metrics
        return [
            'genre_match_rate' => 0.82,
            'trope_match_rate' => 0.76,
            'author_match_rate' => 0.68,
        ];
    }

    private function getCollaborativeEffectiveness()
    {
        // Simulate collaborative filtering effectiveness
        return [
            'user_similarity_accuracy' => 0.71,
            'co_purchase_accuracy' => 0.79,
            'collaborative_coverage' => 0.65,
        ];
    }

    private function getRecommendationDiversity()
    {
        return [
            'genre_diversity' => 0.85,
            'author_diversity' => 0.78,
            'price_range_diversity' => 0.72,
        ];
    }

    private function getColdStartAnalysis()
    {
        $newUsers = User::role('customer')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();
        
        $newBooks = Book::where('created_at', '>=', now()->subDays(30))->count();
        
        return [
            'new_users_last_30_days' => $newUsers,
            'new_books_last_30_days' => $newBooks,
            'cold_start_challenge_score' => 0.3, // Lower is better
        ];
    }

    private function calculatePrecision()
    {
        // Simulate precision calculation
        return 0.68; // 68% precision
    }

    private function calculateRecall()
    {
        // Simulate recall calculation
        return 0.72; // 72% recall
    }

    private function calculateF1Score($precision, $recall)
    {
        if ($precision + $recall == 0) return 0;
        return round(2 * ($precision * $recall) / ($precision + $recall), 3);
    }

    private function getAccuracyTrend()
    {
        // Simulate accuracy trend over time
        return [
            'last_week' => 0.70,
            'last_month' => 0.68,
            'last_quarter' => 0.65,
            'trend' => 'improving',
        ];
    }

    /**
     * Get detailed recommendation data for a specific user
     */
    public function userDetails(User $user)
    {
        $userRecommendations = $this->recommendationService->recommendForUser($user, 20);
        $userOrders = $user->orders()->with('items.book')->get();
        $userWishlist = $user->wishlistBooks()->get();
        
        // Analyze user preferences
        $userPreferences = $this->analyzeUserPreferences($user);
        
        return view('admin.recommendations.user-details', compact(
            'user',
            'userRecommendations',
            'userOrders',
            'userWishlist',
            'userPreferences'
        ));
    }

    private function analyzeUserPreferences(User $user)
    {
        $orders = $user->orders()->where('status', 'completed')->with('items.book')->get();
        
        $genrePreferences = [];
        $tropePreferences = [];
        $authorPreferences = [];
        
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $book = $item->book;
                
                // Genre preferences
                if ($book->genre) {
                    $genrePreferences[$book->genre->name] = ($genrePreferences[$book->genre->name] ?? 0) + $item->quantity;
                }
                
                // Author preferences
                $authorPreferences[$book->author] = ($authorPreferences[$book->author] ?? 0) + $item->quantity;
                
                // Trope preferences
                foreach ($book->tropes as $trope) {
                    $tropePreferences[$trope->name] = ($tropePreferences[$trope->name] ?? 0) + $item->quantity;
                }
            }
        }
        
        return [
            'genres' => collect($genrePreferences)->sortDesc()->take(5),
            'tropes' => collect($tropePreferences)->sortDesc()->take(5),
            'authors' => collect($authorPreferences)->sortDesc()->take(5),
        ];
    }

    /**
     * Get recommendation settings and allow admin to modify them
     */
    public function settings()
    {
        $settings = [
            'content_based_weight' => 0.6,
            'collaborative_weight' => 0.4,
            'min_recommendation_score' => 0.3,
            'max_recommendations_per_user' => 12,
            'cache_duration_hours' => 24,
            'enable_content_based' => true,
            'enable_collaborative' => true,
        ];
        
        return view('admin.recommendations.settings', compact('settings'));
    }

    /**
     * Update recommendation settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'content_based_weight' => 'required|numeric|min:0|max:1',
            'collaborative_weight' => 'required|numeric|min:0|max:1',
            'min_recommendation_score' => 'required|numeric|min:0|max:1',
            'max_recommendations_per_user' => 'required|integer|min:1|max:50',
            'cache_duration_hours' => 'required|integer|min:1|max:168',
            'enable_content_based' => 'boolean',
            'enable_collaborative' => 'boolean',
        ]);

        // Validate that weights sum to 1
        $totalWeight = $request->content_based_weight + $request->collaborative_weight;
        if (abs($totalWeight - 1.0) > 0.01) {
            return back()->withErrors(['weights' => 'Content-based and collaborative weights must sum to 1.0']);
        }

        // Store settings (in a real implementation, you'd save these to a settings table)
        Cache::put('recommendation_settings', $request->all(), now()->addDays(30));
        
        // Clear recommendation cache to apply new settings
        Cache::tags(['recommendations'])->flush();
        
        return redirect()->route('admin.recommendations.settings')
            ->with('success', 'Recommendation settings updated successfully!');
    }
}
