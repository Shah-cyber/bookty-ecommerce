<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
        // Get best selling books this month
        $bestSellingBooks = Book::with(['genre', 'reviews'])
            ->whereHas('orderItems', function($query) {
                $query->whereHas('order', function($q) {
                    $q->where('status', 'completed')
                      ->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                });
            })
            ->withCount(['orderItems as total_sold' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->where('status', 'completed')
                      ->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                });
            }])
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
        
        // Get recent customers
        $recentCustomers = User::role('customer')
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalBooks',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'pendingOrdersCount',
            'recentOrders',
            'lowStockBooks',
            'bestSellingBooks',
            'recentCustomers'
        ));
    }

    /**
     * Provide Top Selling Books data for a given period.
     */
    public function getTopSellingBooksData(Request $request)
    {
        $period = $request->get('period', 'last_6_months');

        // Resolve date range
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

        $books = Book::whereHas('orderItems', function($query) use ($start, $end) {
                $query->whereHas('order', function($q) use ($start, $end) {
                    $q->where('status', 'completed')
                      ->whereBetween('created_at', [$start, $end]);
                });
            })
            ->withCount(['orderItems as total_sold' => function($query) use ($start, $end) {
                $query->whereHas('order', function($q) use ($start, $end) {
                    $q->where('status', 'completed')
                      ->whereBetween('created_at', [$start, $end]);
                });
            }])
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get(['id', 'title', 'price']);

        $titles = $books->pluck('title');
        $quantities = $books->pluck('total_sold');
        $prices = $books->pluck('price');

        $totalSold = (int) $quantities->sum();
        $topTitle = $books->first()->title ?? null;
        $totalTitles = $books->count();

        return response()->json([
            'titles' => $titles,
            'quantities' => $quantities,
            'prices' => $prices,
            'summary' => [
                'total_sold' => $totalSold,
                'top_title' => $topTitle,
                'total_titles' => $totalTitles,
            ],
        ]);
    }

    /**
     * Sales totals series for a period (daily aggregation) + summary and change percent.
     */
    public function getSalesThisPeriodData(Request $request)
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

        // Compare with previous equivalent period
        $prevStart = (clone $start)->subDays($intervalDays);
        $prevEnd = (clone $start);
        $prevTotal = Order::where('status', 'completed')
            ->whereBetween('created_at', [$prevStart, $prevEnd])
            ->sum('total_amount');
        $changePercent = $prevTotal > 0 ? round((($totalRevenue - $prevTotal) / $prevTotal) * 100, 2) : 0.0;

        return response()->json([
            'labels' => $labels,
            'revenue' => $revenue,
            'orders' => $orders,
            'summary' => [
                'total_revenue' => $totalRevenue,
                'change_percent' => $changePercent,
            ],
        ]);
    }
}
