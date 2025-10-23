<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard cards
        $totalAdmins = User::role('admin')->count();
        $totalCustomers = User::role('customer')->count();
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
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
        $recentUsers = User::latest()->take(5)->get();
        
        // Get order statistics
        $orderStats = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
        
        return view('superadmin.dashboard', compact(
            'totalAdmins',
            'totalCustomers',
            'totalBooks',
            'totalOrders',
            'totalRevenue',
            'userRegistrations',
            'recentUsers',
            'orderStats'
        ));
    }

    /**
     * Get real-time statistics for the dashboard
     */
    public function getRealtimeStats(Request $request)
    {
        $stats = [
            'totalAdmins' => User::role('admin')->count(),
            'totalCustomers' => User::role('customer')->count(),
            'totalBooks' => Book::count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::where('status', 'completed')->sum('total_amount'),
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
}
