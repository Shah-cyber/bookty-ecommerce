<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard cards
        $totalAdmins = User::role('admin')->count();
        $totalSuperAdmins = User::role('superadmin')->count();
        $totalCustomers = User::role('customer')->count();
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        // Today's stats
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount');
        $todayUsers = User::whereDate('created_at', today())->count();
        
        // This month's stats
        $thisMonthOrders = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $thisMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        
        // Last month's stats for comparison
        $lastMonthOrders = Order::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');
        
        // Calculate trends
        $revenueTrend = $lastMonthRevenue > 0 
            ? round((($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1) 
            : 0;
        $ordersTrend = $lastMonthOrders > 0 
            ? round((($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1) 
            : 0;
        
        // Customer trend
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
        
        // Get user registrations by month for chart
        $userRegistrations = User::select(
            DB::raw('MONTH(created_at) as month'), 
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();
        
        // Get recent users
        $recentUsers = User::with('roles')->latest()->take(5)->get();
        
        // Get recent orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        // Get order statistics
        $orderStats = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        // Low stock books
        $lowStockBooks = Book::where('stock', '<', 10)->orderBy('stock', 'asc')->take(5)->get();
        $lowStockCount = Book::where('stock', '<', 10)->count();
        
        // Best selling books this month
        $bestSellingBooks = Book::select('books.*')
            ->join('order_items', 'books.id', '=', 'order_items.book_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->groupBy('books.id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();
        
        return view('superadmin.dashboard', compact(
            'totalAdmins',
            'totalSuperAdmins',
            'totalCustomers',
            'totalBooks',
            'totalOrders',
            'totalRevenue',
            'todayOrders',
            'todayRevenue',
            'todayUsers',
            'thisMonthRevenue',
            'thisMonthOrders',
            'revenueTrend',
            'ordersTrend',
            'customersTrend',
            'userRegistrations',
            'recentUsers',
            'recentOrders',
            'orderStats',
            'lowStockBooks',
            'lowStockCount',
            'bestSellingBooks'
        ));
    }

    /**
     * Get real-time statistics for the dashboard
     */
    public function getRealtimeStats(Request $request)
    {
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::where('status', 'completed')->whereDate('created_at', today())->sum('total_amount');
        $todayUsers = User::whereDate('created_at', today())->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        $stats = [
            'totalAdmins' => User::role('admin')->count(),
            'totalCustomers' => User::role('customer')->count(),
            'totalBooks' => Book::count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::where('status', 'completed')->sum('total_amount'),
            'todayOrders' => $todayOrders,
            'todayRevenue' => $todayRevenue,
            'todayUsers' => $todayUsers,
            'pendingOrders' => $pendingOrders,
            'orderStats' => [
                'pending' => Order::where('status', 'pending')->count(),
                'processing' => Order::where('status', 'processing')->count(),
                'shipped' => Order::where('status', 'shipped')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count(),
            ],
            'lastUpdated' => now()->toISOString(),
        ];

        return response()->json($stats);
    }

    /**
     * Get real-time user registrations data for chart
     */
    public function getRealtimeUserRegistrations(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        $registrations = User::select(
            DB::raw('MONTH(created_at) as month'), 
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', $year)
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        // Fill in missing months with 0 count
        $monthlyData = array_fill(1, 12, 0);
        foreach ($registrations as $registration) {
            $monthlyData[$registration->month] = $registration->count;
        }

        return response()->json([
            'year' => $year,
            'data' => array_values($monthlyData),
            'total' => array_sum($monthlyData),
            'lastUpdated' => now()->toISOString(),
        ]);
    }

    /**
     * Get recent users for real-time updates
     */
    public function getRecentUsers(Request $request)
    {
        $limit = $request->get('limit', 5);
        
        $recentUsers = User::with('roles')
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->pluck('name'),
                    'created_at' => $user->created_at->toISOString(),
                    'created_at_formatted' => $user->created_at->format('M d, Y'),
                    'avatar' => strtoupper(substr($user->name, 0, 1)),
                ];
            });

        return response()->json([
            'users' => $recentUsers,
            'count' => $recentUsers->count(),
            'lastUpdated' => now()->toISOString(),
        ]);
    }

    /**
     * Get system health metrics
     */
    public function getSystemHealth(Request $request)
    {
        // Calculate some basic system health metrics
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayUsers = User::whereDate('created_at', today())->count();
        $avgOrderValue = Order::where('status', 'completed')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->avg('total_amount') ?? 0;
        
        // Calculate growth percentages
        $yesterdayOrders = Order::whereDate('created_at', today()->subDay())->count();
        $orderGrowth = $yesterdayOrders > 0 
            ? round((($todayOrders - $yesterdayOrders) / $yesterdayOrders) * 100, 1)
            : 0;

        $lastMonthUsers = User::whereDate('created_at', '>=', now()->subDays(30))->count();
        $previousMonthUsers = User::whereDate('created_at', '>=', now()->subDays(60))
            ->whereDate('created_at', '<', now()->subDays(30))->count();
        $userGrowth = $previousMonthUsers > 0
            ? round((($lastMonthUsers - $previousMonthUsers) / $previousMonthUsers) * 100, 1)
            : 0;

        return response()->json([
            'todayOrders' => $todayOrders,
            'todayUsers' => $todayUsers,
            'avgOrderValue' => round($avgOrderValue, 2),
            'orderGrowth' => $orderGrowth,
            'userGrowth' => $userGrowth,
            'systemStatus' => 'healthy',
            'lastUpdated' => now()->toISOString(),
        ]);
    }

    /**
     * Get sales data for a given period
     */
    public function getSalesData(Request $request)
    {
        $period = $request->get('period', 'this_week');

        $end = now();
        switch ($period) {
            case 'this_week':
                $start = now()->startOfWeek();
                $intervalDays = 7;
                break;
            case 'yesterday':
                $start = now()->subDay()->startOfDay();
                $end = now()->subDay()->endOfDay();
                $intervalDays = 1;
                break;
            case 'today':
                $start = now()->startOfDay();
                $intervalDays = 1;
                break;
            case 'last_30_days':
                $start = now()->subDays(30);
                $intervalDays = 30;
                break;
            case 'last_90_days':
                $start = now()->subDays(90);
                $intervalDays = 90;
                break;
            case 'last_7_days':
                $start = now()->subDays(7);
                $intervalDays = 7;
                break;
            case 'this_month':
                $start = now()->startOfMonth();
                $intervalDays = now()->daysInMonth;
                break;
            case 'last_month':
                $start = now()->subMonth()->startOfMonth();
                $end = now()->subMonth()->endOfMonth();
                $intervalDays = $end->daysInMonth;
                break;
            default:
                $start = now()->subDays(7);
                $intervalDays = 7;
                break;
        }

        $series = Order::where('status', 'completed')
            ->whereBetween('created_at', [$start, $end])
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
        $map = $series->keyBy('day');
        while ($cursor <= $last) {
            $key = $cursor->toDateString();
            $labels[] = $cursor->format('d M');
            $revenue[] = isset($map[$key]) ? (float) $map[$key]->revenue : 0.0;
            $orders[] = isset($map[$key]) ? (int) $map[$key]->orders_count : 0;
            $cursor->addDay();
        }

        $totalRevenue = array_sum($revenue);
        $totalOrders = array_sum($orders);

        // Compare with previous equivalent period
        $prevStart = (clone $start)->subDays($intervalDays);
        $prevEnd = (clone $start);
        $prevTotal = Order::where('status', 'completed')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('total_amount');
        $changePercent = $prevTotal > 0 ? round((($totalRevenue - $prevTotal) / $prevTotal) * 100, 1) : 0.0;

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
     * Get top selling books data
     */
    public function getTopSellingBooks(Request $request)
    {
        $period = $request->get('period', 'last_6_months');

        $end = now();
        switch ($period) {
            case 'yesterday':
                $start = now()->subDay()->startOfDay();
                $end = now()->subDay()->endOfDay();
                break;
            case 'today':
                $start = now()->startOfDay();
                $end = now()->endOfDay();
                break;
            case 'last_7_days':
                $start = now()->subDays(7);
                break;
            case 'last_30_days':
                $start = now()->subDays(30);
                break;
            case 'last_90_days':
                $start = now()->subDays(90);
                break;
            case 'last_year':
                $start = now()->subYear();
                break;
            case 'last_6_months':
            default:
                $start = now()->subMonths(6);
                break;
        }

        $books = Book::select('books.id', 'books.title', 'books.price')
            ->join('order_items', 'books.id', '=', 'order_items.book_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$start, $end])
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
        $totalRevenue = $revenues->sum();

        return response()->json([
            'titles' => $titles,
            'quantities' => $quantities,
            'prices' => $prices,
            'revenues' => $revenues,
            'summary' => [
                'total_sold' => $totalSold,
                'top_title' => $topTitle,
                'total_revenue' => $totalRevenue,
            ],
        ]);
    }
}
