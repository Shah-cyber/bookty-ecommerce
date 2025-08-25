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
        
        // Get recent orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        // Get low stock books
        $lowStockBooks = Book::where('stock', '<', 10)->orderBy('stock', 'asc')->take(5)->get();
        
        return view('admin.dashboard', compact(
            'totalBooks',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'recentOrders',
            'lowStockBooks'
        ));
    }
}
