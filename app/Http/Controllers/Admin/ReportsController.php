<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Genre;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\FlashSale;
use App\Models\BookDiscount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProfitabilityReportExport;
use App\Exports\SalesReportExport;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view reports')->only([
            'index', 'sales', 'customers', 'inventory', 'promotions', 'shipping', 'profitability',
        ]);
        $this->middleware('permission:export reports')->only([
            'exportSales', 'exportCustomers', 'exportProfitability',
        ]);
    }

    /**
     * Display the reports dashboard.
     */
    public function index()
    {
        // Get basic stats for the reports dashboard
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalCustomers = User::role('customer')->count();
        $totalBooks = Book::count();
        
        return view('admin.reports.index', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'totalBooks'
        ));
    }

    /**
     * Sales Reports
     */
    public function sales(Request $request)
    {
        $period = $request->get('period', 'monthly'); // daily, monthly, yearly
        $startDate = $request->get('start_date', now()->subMonths(12));
        $endDate = $request->get('end_date', now());

        // Revenue over time
        $revenueData = $this->getRevenueOverTime($startDate, $endDate, $period);
        
        // Bestsellers by revenue
        $bestsellersByRevenue = $this->getBestsellersByRevenue($startDate, $endDate);
        
        // Bestsellers by units sold
        $bestsellersByUnits = $this->getBestsellersByUnits($startDate, $endDate);
        
        // Sales by genre
        $salesByGenre = $this->getSalesByGenre($startDate, $endDate);
        
        // Sales by author
        $salesByAuthor = $this->getSalesByAuthor($startDate, $endDate);

        return view('admin.reports.sales', compact(
            'revenueData',
            'bestsellersByRevenue',
            'bestsellersByUnits',
            'salesByGenre',
            'salesByAuthor',
            'period',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Customer Reports
     */
    public function customers(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonths(12));
        $endDate = $request->get('end_date', now());

        // New vs Returning customers
        $customerStats = $this->getCustomerStats($startDate, $endDate);
        
        // Top spenders
        $topSpenders = $this->getTopSpenders($startDate, $endDate);
        
        // Customer segmentation
        $customerSegmentation = $this->getCustomerSegmentation($startDate, $endDate);
        
        // Inactive customers
        $inactiveCustomers = $this->getInactiveCustomers();

        return view('admin.reports.customers', compact(
            'customerStats',
            'topSpenders',
            'customerSegmentation',
            'inactiveCustomers',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Inventory Reports
     */
    public function inventory(Request $request)
    {
        // Low stock & out of stock
        $lowStockBooks = Book::where('stock', '<', 10)->orderBy('stock', 'asc')->get();
        $outOfStockBooks = Book::where('stock', 0)->get();
        
        // Dead stock (books unsold for X months)
        $deadStockMonths = $request->get('dead_stock_months', 6);
        $deadStockBooks = $this->getDeadStockBooks($deadStockMonths);
        
        // Fastest selling books (turnover rate)
        $fastestSellingBooks = $this->getFastestSellingBooks();

        return view('admin.reports.inventory', compact(
            'lowStockBooks',
            'outOfStockBooks',
            'deadStockBooks',
            'fastestSellingBooks',
            'deadStockMonths'
        ));
    }

    /**
     * Promotions & Discounts Reports
     */
    public function promotions(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonths(6));
        $endDate = $request->get('end_date', now());

        // Coupon usage statistics
        $couponStats = $this->getCouponStats($startDate, $endDate);
        
        // Flash sale performance
        $flashSalePerformance = $this->getFlashSalePerformance($startDate, $endDate);
        
        // Conversion rate from promotions
        $promotionConversion = $this->getPromotionConversion($startDate, $endDate);

        return view('admin.reports.promotions', compact(
            'couponStats',
            'flashSalePerformance',
            'promotionConversion',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Shipping & Orders Reports
     */
    public function shipping(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonths(6));
        $endDate = $request->get('end_date', now());

        // Orders by status
        $ordersByStatus = $this->getOrdersByStatus($startDate, $endDate);
        
        // Average shipping time
        $avgShippingTime = $this->getAverageShippingTime($startDate, $endDate);
        
        // Refunds & cancellations rate
        $refundCancellationStats = $this->getRefundCancellationStats($startDate, $endDate);

        return view('admin.reports.shipping', compact(
            'ordersByStatus',
            'avgShippingTime',
            'refundCancellationStats',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Profitability Reports
     */
    public function profitability(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonths(12));
        $endDate = $request->get('end_date', now());

        // Gross profit margin per book
        $profitMarginByBook = $this->getProfitMarginByBook($startDate, $endDate);
        
        // Gross profit margin per genre
        $profitMarginByGenre = $this->getProfitMarginByGenre($startDate, $endDate);
        
        // Monthly profit vs expenses
        $monthlyProfitExpenses = $this->getMonthlyProfitExpenses($startDate, $endDate);
        
        // Refund/return loss analysis
        $refundLossAnalysis = $this->getRefundLossAnalysis($startDate, $endDate);

        return view('admin.reports.profitability', compact(
            'profitMarginByBook',
            'profitMarginByGenre',
            'monthlyProfitExpenses',
            'refundLossAnalysis',
            'startDate',
            'endDate'
        ));
    }

    // Helper methods for data retrieval

    private function getRevenueOverTime($startDate, $endDate, $period)
    {
        $query = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate]);

        switch ($period) {
            case 'daily':
                return $query->selectRaw('DATE(created_at) as period, SUM(total_amount) as revenue, COUNT(*) as orders_count')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();
            case 'monthly':
                return $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, SUM(total_amount) as revenue, COUNT(*) as orders_count')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();
            case 'yearly':
                return $query->selectRaw('YEAR(created_at) as period, SUM(total_amount) as revenue, COUNT(*) as orders_count')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();
        }
    }

    private function getBestsellersByRevenue($startDate, $endDate)
    {
        return Book::with(['genre'])
            ->whereHas('orderItems', function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
                });
            })
            ->withSum(['orderItems as total_revenue' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
                });
            }], DB::raw('quantity * price'))
            ->orderBy('total_revenue', 'desc')
            ->take(10)
            ->get();
    }

    private function getBestsellersByUnits($startDate, $endDate)
    {
        return Book::with(['genre'])
            ->whereHas('orderItems', function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
                });
            })
            ->withSum(['orderItems as total_units' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
                });
            }], 'quantity')
            ->orderBy('total_units', 'desc')
            ->take(10)
            ->get();
    }

    private function getSalesByGenre($startDate, $endDate)
    {
        return Genre::withCount(['books as books_count'])
            ->whereHas('books', function($query) use ($startDate, $endDate) {
                $query->whereHas('orderItems', function($q) use ($startDate, $endDate) {
                    $q->whereHas('order', function($orderQuery) use ($startDate, $endDate) {
                        $orderQuery->where('status', 'completed')
                                  ->whereBetween('created_at', [$startDate, $endDate]);
                    });
                });
            })
            ->get()
            ->map(function($genre) use ($startDate, $endDate) {
                $totalRevenue = DB::table('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->join('books', 'order_items.book_id', '=', 'books.id')
                    ->where('books.genre_id', $genre->id)
                    ->where('orders.status', 'completed')
                    ->whereBetween('orders.created_at', [$startDate, $endDate])
                    ->sum(DB::raw('order_items.quantity * order_items.price'));
                
                $genre->total_revenue = $totalRevenue;
                return $genre;
            })
            ->sortByDesc('total_revenue');
    }

    private function getSalesByAuthor($startDate, $endDate)
    {
        return DB::table('books')
            ->join('order_items', 'books.id', '=', 'order_items.book_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('books.author')
            ->selectRaw('SUM(order_items.quantity * order_items.price) as total_revenue')
            ->selectRaw('SUM(order_items.quantity) as total_units')
            ->groupBy('books.author')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();
    }

    private function getCustomerStats($startDate, $endDate)
    {
        $totalCustomers = User::role('customer')->count();
        $newCustomers = User::role('customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $returningCustomers = User::role('customer')
            ->whereHas('orders', function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->count();

        return [
            'total' => $totalCustomers,
            'new' => $newCustomers,
            'returning' => $returningCustomers,
            'new_percentage' => $totalCustomers > 0 ? round(($newCustomers / $totalCustomers) * 100, 2) : 0,
            'returning_percentage' => $totalCustomers > 0 ? round(($returningCustomers / $totalCustomers) * 100, 2) : 0,
        ];
    }

    private function getTopSpenders($startDate, $endDate)
    {
        return User::role('customer')
            ->whereHas('orders', function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->withSum(['orders as total_spent' => function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_amount')
            ->withCount(['orders as total_orders' => function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();
    }

    private function getCustomerSegmentation($startDate, $endDate)
    {
        $customers = User::role('customer')
            ->whereHas('orders', function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->withSum(['orders as total_spent' => function($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            }], 'total_amount')
            ->get();

        $totalSpent = $customers->sum('total_spent');
        $avgSpent = $customers->count() > 0 ? $totalSpent / $customers->count() : 0;

        $lowSpenders = $customers->where('total_spent', '<', $avgSpent * 0.5)->count();
        $mediumSpenders = $customers->whereBetween('total_spent', [$avgSpent * 0.5, $avgSpent * 1.5])->count();
        $highSpenders = $customers->where('total_spent', '>', $avgSpent * 1.5)->count();

        return [
            'low' => $lowSpenders,
            'medium' => $mediumSpenders,
            'high' => $highSpenders,
            'total' => $customers->count(),
            'avg_spent' => $avgSpent,
        ];
    }

    private function getInactiveCustomers()
    {
        return User::role('customer')
            ->whereDoesntHave('orders', function($query) {
                $query->where('created_at', '>=', now()->subMonths(6));
            })
            ->withCount('orders')
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();
    }

    private function getDeadStockBooks($months)
    {
        return Book::whereDoesntHave('orderItems', function($query) use ($months) {
            $query->whereHas('order', function($q) use ($months) {
                $q->where('status', 'completed')
                  ->where('created_at', '>=', now()->subMonths($months));
            });
        })
        ->where('stock', '>', 0)
        ->orderBy('created_at', 'asc')
        ->get();
    }

    private function getFastestSellingBooks()
    {
        return Book::with(['genre'])
            ->whereHas('orderItems')
            ->withCount(['orderItems as total_sold'])
            ->withSum('orderItems', 'quantity')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();
    }

    private function getCouponStats($startDate, $endDate)
    {
        $totalCoupons = Coupon::count();
        $activeCoupons = Coupon::where('is_active', true)->count();
        $totalUsages = CouponUsage::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalDiscountGiven = CouponUsage::whereBetween('created_at', [$startDate, $endDate])->sum('discount_amount');

        return [
            'total_coupons' => $totalCoupons,
            'active_coupons' => $activeCoupons,
            'total_usages' => $totalUsages,
            'total_discount_given' => $totalDiscountGiven,
        ];
    }

    private function getFlashSalePerformance($startDate, $endDate)
    {
        return FlashSale::withCount('books')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    private function getPromotionConversion($startDate, $endDate)
    {
        // This would need more complex logic based on your promotion tracking
        // For now, return basic stats
        return [
            'coupon_orders' => Order::whereNotNull('coupon_id')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'total_orders' => Order::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];
    }

    private function getOrdersByStatus($startDate, $endDate)
    {
        return Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
    }

    private function getAverageShippingTime($startDate, $endDate)
    {
        // This would need shipping tracking data
        // For now, return placeholder data
        return [
            'avg_days' => 3.5,
            'fastest' => 1,
            'slowest' => 7,
        ];
    }

    private function getRefundCancellationStats($startDate, $endDate)
    {
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $cancelledOrders = Order::where('status', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        return [
            'total_orders' => $totalOrders,
            'cancelled_orders' => $cancelledOrders,
            'cancellation_rate' => $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 2) : 0,
        ];
    }

    private function getProfitMarginByBook($startDate, $endDate)
    {
        return DB::table('books')
            ->join('order_items', 'books.id', '=', 'order_items.book_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotNull('order_items.cost_price')
            ->where('order_items.cost_price', '>', 0)
            ->select('books.id', 'books.title', 'books.author', 'books.price', 'books.cost_price', 'books.cover_image')
            ->selectRaw('SUM(order_items.total_selling) as total_revenue')
            ->selectRaw('SUM(order_items.total_cost) as total_cost')
            ->selectRaw('SUM(order_items.total_selling - order_items.total_cost) as total_profit')
            ->selectRaw('ROUND((SUM(order_items.total_selling - order_items.total_cost) / SUM(order_items.total_selling)) * 100, 2) as profit_margin')
            ->groupBy('books.id', 'books.title', 'books.author', 'books.price', 'books.cost_price', 'books.cover_image')
            ->orderBy('total_profit', 'desc')
            ->limit(10)
            ->get();
    }

    private function getProfitMarginByGenre($startDate, $endDate)
    {
        return DB::table('genres')
            ->join('books', 'genres.id', '=', 'books.genre_id')
            ->join('order_items', 'books.id', '=', 'order_items.book_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotNull('order_items.cost_price')
            ->where('order_items.cost_price', '>', 0)
            ->select('genres.id', 'genres.name')
            ->selectRaw('SUM(order_items.total_selling) as total_revenue')
            ->selectRaw('SUM(order_items.total_cost) as total_cost')
            ->selectRaw('SUM(order_items.total_selling - order_items.total_cost) as total_profit')
            ->selectRaw('ROUND((SUM(order_items.total_selling - order_items.total_cost) / SUM(order_items.total_selling)) * 100, 2) as profit_margin')
            ->groupBy('genres.id', 'genres.name')
            ->orderBy('total_profit', 'desc')
            ->get();
    }

    private function getMonthlyProfitExpenses($startDate, $endDate)
    {
        return DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotNull('order_items.cost_price')
            ->where('order_items.cost_price', '>', 0)
            ->selectRaw('DATE_FORMAT(orders.created_at, "%Y-%m") as month')
            ->selectRaw('SUM(order_items.total_selling) as revenue')
            ->selectRaw('SUM(order_items.total_cost) as cost')
            ->selectRaw('SUM(order_items.total_selling - order_items.total_cost) as profit')
            ->selectRaw('ROUND((SUM(order_items.total_selling - order_items.total_cost) / SUM(order_items.total_selling)) * 100, 2) as profit_margin')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    private function getRefundLossAnalysis($startDate, $endDate)
    {
        $totalRevenue = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotNull('order_items.cost_price')
            ->where('order_items.cost_price', '>', 0)
            ->sum('order_items.total_selling');
        
        $totalCost = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotNull('order_items.cost_price')
            ->where('order_items.cost_price', '>', 0)
            ->sum('order_items.total_cost');
        
        $refundedRevenue = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'cancelled')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotNull('order_items.cost_price')
            ->where('order_items.cost_price', '>', 0)
            ->sum('order_items.total_selling');
        
        $refundedCost = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'cancelled')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotNull('order_items.cost_price')
            ->where('order_items.cost_price', '>', 0)
            ->sum('order_items.total_cost');

        $totalProfit = $totalRevenue - $totalCost;
        $refundedProfit = $refundedRevenue - $refundedCost;

        return [
            'total_revenue' => $totalRevenue,
            'total_cost' => $totalCost,
            'total_profit' => $totalProfit,
            'refunded_revenue' => $refundedRevenue,
            'refunded_cost' => $refundedCost,
            'refunded_profit' => $refundedProfit,
            'refund_percentage' => $totalRevenue > 0 ? round(($refundedRevenue / $totalRevenue) * 100, 2) : 0,
            'profit_loss_percentage' => $totalProfit > 0 ? round(($refundedProfit / $totalProfit) * 100, 2) : 0,
        ];
    }

    // Export methods

    /**
     * Export profitability report to Excel
     */
    public function exportProfitability(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonths(12));
        $endDate = $request->get('end_date', now());
        $type = $request->get('type', 'books'); // books, genres, monthly

        switch ($type) {
            case 'books':
                $data = $this->getProfitMarginByBook($startDate, $endDate);
                break;
            case 'genres':
                $data = $this->getProfitMarginByGenre($startDate, $endDate);
                break;
            case 'monthly':
                $data = $this->getMonthlyProfitExpenses($startDate, $endDate);
                break;
            default:
                $data = $this->getProfitMarginByBook($startDate, $endDate);
        }

        $fileName = 'profitability_report_' . $type . '_' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new ProfitabilityReportExport($data, $type), $fileName);
    }

    /**
     * Export sales report to Excel
     */
    public function exportSales(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonths(12));
        $endDate = $request->get('end_date', now());
        $type = $request->get('type', 'bestsellers'); // bestsellers, authors, genres

        switch ($type) {
            case 'bestsellers':
                $data = $this->getBestsellersByRevenue($startDate, $endDate);
                break;
            case 'authors':
                $data = $this->getSalesByAuthor($startDate, $endDate);
                break;
            case 'genres':
                $data = $this->getSalesByGenre($startDate, $endDate);
                break;
            default:
                $data = $this->getBestsellersByRevenue($startDate, $endDate);
        }

        $fileName = 'sales_report_' . $type . '_' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new SalesReportExport($data, $type), $fileName);
    }

    /**
     * Export customer report to Excel
     */
    public function exportCustomers(Request $request)
    {
        $startDate = $request->get('start_date', now()->subMonths(12));
        $endDate = $request->get('end_date', now());
        $type = $request->get('type', 'top_spenders'); // top_spenders, segmentation

        switch ($type) {
            case 'top_spenders':
                $data = $this->getTopSpenders($startDate, $endDate);
                break;
            case 'segmentation':
                $data = collect([$this->getCustomerSegmentation($startDate, $endDate)]);
                break;
            default:
                $data = $this->getTopSpenders($startDate, $endDate);
        }

        $fileName = 'customer_report_' . $type . '_' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new SalesReportExport($data, 'customers'), $fileName);
    }
}
