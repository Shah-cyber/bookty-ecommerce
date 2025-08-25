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
}
