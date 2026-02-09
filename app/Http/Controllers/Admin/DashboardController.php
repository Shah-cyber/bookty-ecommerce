<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $totalCustomers = User::role('customer')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        // Get pending orders count
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        
        // Get recent orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        // Get low stock books
        $lowStockBooks = Book::where('stock', '<', 10)->orderBy('stock', 'asc')->take(5)->get();
        
        // Get best selling books this month (sum of quantities, not count of order items)
        // Using subquery approach to avoid MySQL ONLY_FULL_GROUP_BY issues
        $bestSellingBookIds = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->selectRaw('order_items.book_id, SUM(order_items.quantity) as total_sold')
            ->groupBy('order_items.book_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->pluck('total_sold', 'book_id');
        
        $bestSellingBooks = Book::whereIn('id', $bestSellingBookIds->keys())
            ->get()
            ->map(function ($book) use ($bestSellingBookIds) {
                $book->total_sold = $bestSellingBookIds[$book->id] ?? 0;
                return $book;
            })
            ->sortByDesc('total_sold')
            ->values();
        
        // Get recent customers
        $recentCustomers = User::role('customer')
            ->latest()
            ->take(5)
            ->get();
        
        // Calculate trends (compare with last month)
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');
        
        $thisMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        
        $revenueTrend = $lastMonthRevenue > 0 
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) 
            : 0;
        
        // Orders trend
        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $thisMonthOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $ordersTrend = $lastMonthOrders > 0 
            ? round((($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1) 
            : 0;
        
        // Customers trend
        $lastMonthCustomers = User::role('customer')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        
        $thisMonthCustomers = User::role('customer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $customersTrend = $lastMonthCustomers > 0 
            ? round((($thisMonthCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100, 1) 
            : 0;
        
        // Today's stats
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount');
        
        // Order status distribution
        $orderStatusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        return view('admin.dashboard', compact(
            'totalBooks',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'pendingOrdersCount',
            'recentOrders',
            'lowStockBooks',
            'bestSellingBooks',
            'recentCustomers',
            'revenueTrend',
            'ordersTrend',
            'customersTrend',
            'todayOrders',
            'todayRevenue',
            'orderStatusCounts'
        ));
    }

    /**
     * Provide Top Selling Books data for a given period.
     */
    public function getTopSellingBooksData(Request $request)
    {
        $period = $request->get('period', 'last_6_months');

        // Resolve date range - ensure we use Carbon instances and proper timezone
        $end = Carbon::now();
        switch ($period) {
            case 'yesterday':
                $start = Carbon::yesterday()->startOfDay();
                $end = Carbon::yesterday()->endOfDay();
                break;
            case 'today':
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                break;
            case 'last_7_days':
                $start = Carbon::now()->subDays(7)->startOfDay();
                $end = Carbon::now()->endOfDay();
                break;
            case 'last_30_days':
                $start = Carbon::now()->subDays(30)->startOfDay();
                $end = Carbon::now()->endOfDay();
                break;
            case 'last_90_days':
                $start = Carbon::now()->subDays(90)->startOfDay();
                $end = Carbon::now()->endOfDay();
                break;
            case 'last_year':
                $start = Carbon::now()->subYear()->startOfDay();
                $end = Carbon::now()->endOfDay();
                break;
            case 'last_6_months':
            default:
                $start = Carbon::now()->subMonths(6)->startOfDay();
                $end = Carbon::now()->endOfDay();
                break;
        }

        // Get best selling books using SUM of quantity (not COUNT)
        // Filter by completed orders created within the date range
        $books = Book::select('books.id', 'books.title', 'books.price')
            ->join('order_items', 'books.id', '=', 'order_items.book_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereDate('orders.created_at', '>=', $start->toDateString())
            ->whereDate('orders.created_at', '<=', $end->toDateString())
            ->groupBy('books.id', 'books.title', 'books.price')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->selectRaw('SUM(order_items.quantity * order_items.price) as total_revenue')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        $titles = $books->pluck('title');
        $quantities = $books->pluck('total_sold')->map(fn($v) => (int) $v);
        $prices = $books->pluck('price');
        $revenues = $books->pluck('total_revenue')->map(fn($v) => (float) $v);

        $totalSold = (int) $quantities->sum();
        $topTitle = $books->first()->title ?? null;
        $totalTitles = $books->count();
        $totalRevenue = $revenues->sum();

        return response()->json([
            'titles' => $titles,
            'quantities' => $quantities,
            'prices' => $prices,
            'revenues' => $revenues,
            'summary' => [
                'total_sold' => $totalSold,
                'top_title' => $topTitle,
                'total_titles' => $totalTitles,
                'total_revenue' => $totalRevenue,
            ],
        ]);
    }

    /**
     * Sales totals series for a period (daily aggregation) + summary and change percent.
     */
    public function getSalesThisPeriodData(Request $request)
    {
        $period = $request->get('period', 'this_week');

        // Resolve date range - ensure we use Carbon instances and proper timezone
        $end = Carbon::now();
        switch ($period) {
            case 'this_week':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfDay();
                $intervalDays = 7;
                break;
            case 'yesterday':
                $start = Carbon::yesterday()->startOfDay();
                $end = Carbon::yesterday()->endOfDay();
                $intervalDays = 1;
                break;
            case 'today':
                $start = Carbon::today()->startOfDay();
                $end = Carbon::today()->endOfDay();
                $intervalDays = 1;
                break;
            case 'last_30_days':
                $start = Carbon::now()->subDays(30)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $intervalDays = 30;
                break;
            case 'last_90_days':
                $start = Carbon::now()->subDays(90)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $intervalDays = 90;
                break;
            case 'last_7_days':
                $start = Carbon::now()->subDays(7)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $intervalDays = 7;
                break;
            default:
                $start = Carbon::now()->subDays(7)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $intervalDays = 7;
                break;
        }

        // Filter by completed orders created within the date range
        // Use DATE() function to group by day, ensuring timezone consistency
        $series = Order::where('status', 'completed')
            ->whereDate('created_at', '>=', $start->toDateString())
            ->whereDate('created_at', '<=', $end->toDateString())
            ->selectRaw('DATE(created_at) as day')
            ->selectRaw('SUM(total_amount) as revenue')
            ->selectRaw('COUNT(*) as orders_count')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $labels = [];
        $revenue = [];
        $orders = [];
        $cursor = (clone $start)->startOfDay();
        $last = (clone $end)->startOfDay();
        $map = $series->keyBy(function($item) {
            // Ensure consistent date format for key matching
            return Carbon::parse($item->day)->toDateString();
        });
        
        // Determine if this is a single-day period
        $isSingleDay = $start->toDateString() === $end->toDateString();
        $isToday = $period === 'today';
        $isYesterday = $period === 'yesterday';
        
        while ($cursor <= $last) {
            $key = $cursor->toDateString();
            
            // Format label - use friendly names for single-day periods
            if ($isToday && $cursor->isToday()) {
                $labels[] = 'Today';
            } elseif ($isYesterday && $cursor->toDateString() === Carbon::yesterday()->toDateString()) {
                $labels[] = 'Yesterday';
            } else {
                $labels[] = $cursor->format('d M');
            }
            
            $revenue[] = isset($map[$key]) ? (float) $map[$key]->revenue : 0.0;
            $orders[] = isset($map[$key]) ? (int) $map[$key]->orders_count : 0;
            $cursor->addDay();
        }

        $totalRevenue = array_sum($revenue);
        $totalOrders = array_sum($orders);

        // Compare with previous equivalent period
        // Calculate the previous period date range
        $prevStart = (clone $start)->subDays($intervalDays)->startOfDay();
        $prevEnd = (clone $start)->subDay()->endOfDay();
        
        // Ensure we don't overlap with current period
        if ($prevEnd >= $start) {
            $prevEnd = (clone $start)->subDay()->endOfDay();
        }
        
        $prevTotal = Order::where('status', 'completed')
            ->whereDate('created_at', '>=', $prevStart->toDateString())
            ->whereDate('created_at', '<=', $prevEnd->toDateString())
            ->sum('total_amount');
        
        // Calculate percentage change with proper handling of all scenarios
        $changePercent = 0.0;
        
        if ($prevTotal > 0) {
            // Normal calculation: ((current - previous) / previous) * 100
            $changePercent = round((($totalRevenue - $prevTotal) / $prevTotal) * 100, 1);
        } elseif ($prevTotal == 0 && $totalRevenue > 0) {
            // Previous period had 0, current period has revenue = new sales/infinite increase
            // Show as 100% increase to indicate growth from zero baseline
            $changePercent = 100.0;
        } elseif ($prevTotal == 0 && $totalRevenue == 0) {
            // Both periods have 0 revenue - no change
            $changePercent = 0.0;
        } elseif ($prevTotal < 0) {
            // Edge case: negative previous (shouldn't happen, but handle it)
            $changePercent = 0.0;
        }
        
        // Ensure we return a numeric value
        $changePercent = (float) $changePercent;

        return response()->json([
            'labels' => $labels,
            'revenue' => $revenue,
            'orders' => $orders,
            'summary' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'change_percent' => $changePercent,
                'avg_order_value' => $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0,
            ],
        ]);
    }

    /**
     * Get real-time dashboard stats via AJAX.
     */
    public function getRealtimeStats(Request $request)
    {
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount');
        $pendingOrders = Order::where('status', 'pending')->count();
        $lowStockCount = Book::where('stock', '<', 10)->count();

        return response()->json([
            'today_orders' => $todayOrders,
            'today_revenue' => $todayRevenue,
            'pending_orders' => $pendingOrders,
            'low_stock_count' => $lowStockCount,
        ]);
    }
}
