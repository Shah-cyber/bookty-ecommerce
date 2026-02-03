# Purchase History Retrieval Guide - Bookty E-Commerce

**How the system retrieves and displays user purchase history**

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Entity Relationship for Purchase History](#entity-relationship-for-purchase-history)
3. [Database Query Flow](#database-query-flow)
4. [Laravel Query Examples](#laravel-query-examples)
5. [Order List Page](#order-list-page)
6. [Order Details Page](#order-details-page)
7. [Performance Optimization](#performance-optimization)
8. [Complete SQL Examples](#complete-sql-examples)
9. [Data Presentation](#data-presentation)

---

## Overview

Purchase history retrieval involves querying the `orders` table and its related entities to display a user's complete order history with all details.

### Key Principles

- **User-Scoped Queries**: Only retrieve orders belonging to authenticated user
- **Eager Loading**: Load related entities efficiently to avoid N+1 problems
- **Order by Date**: Most recent orders shown first
- **Snapshot Data**: Display prices as they were at purchase time
- **Status Tracking**: Show current order and payment status

---

## Entity Relationship for Purchase History

```
┌═══════════════════════════════════════════════════════════════════════════════┐
║              ENTITIES INVOLVED IN PURCHASE HISTORY                            ║
└═══════════════════════════════════════════════════════════════════════════════┘

    ┌──────────┐
    │   User   │ id = 5 (authenticated user)
    └────┬─────┘
         │
         │ has many orders
         │ WHERE user_id = 5
         │
         ↓
    ┌──────────────────────────────────────────────────────────┐
    │                       Orders                             │
    │  • public_id (display to user)                          │
    │  • status (pending, processing, shipped, completed)      │
    │  • payment_status (pending, paid, failed)                │
    │  • total_amount (final price paid)                       │
    │  • created_at (order date)                               │
    │  • shipping_address, city, state, postal_code            │
    │  • coupon_code, discount_amount                          │
    │  • is_free_shipping                                      │
    │  • toyyibpay_bill_code, payment_date                     │
    └────┬─────────────────────────────────────────────────────┘
         │
         │ has many order items
         │ (JOIN via order_id)
         │
         ↓
    ┌──────────────────────────────────────────────────────────┐
    │                    Order_Items                           │
    │  • book_id (FK to books)                                │
    │  • quantity (how many purchased)                         │
    │  • price (snapshot at purchase time)                     │
    │  • cost_price (snapshot at purchase time)                │
    └────┬─────────────────────────────────────────────────────┘
         │
         │ references book
         │ (JOIN via book_id)
         │
         ↓
    ┌──────────────────────────────────────────────────────────┐
    │                       Books                              │
    │  • title (display name)                                 │
    │  • slug (for linking to book page)                       │
    │  • cover_image (display image)                           │
    │  • author (display author)                               │
    │  • price (CURRENT price - may differ from purchase)      │
    └──────────────────────────────────────────────────────────┘

    ┌──────────┐
    │  Orders  │
    └────┬─────┘
         │
         │ may reference (FK)
         │ postage_rate_history_id
         │
         ↓
    ┌────────────────────────┐
    │Postage_Rate_History    │
    │  • region              │
    │  • state               │
    │  • customer_price      │
    │  • actual_cost         │
    │  • valid_from          │
    └────────────────────────┘
```

---

## Database Query Flow

### Step-by-Step Retrieval Process

```
┌═══════════════════════════════════════════════════════════════════════════════┐
║                    PURCHASE HISTORY QUERY FLOW                                ║
└═══════════════════════════════════════════════════════════════════════════════┘

STEP 1: AUTHENTICATE USER
═══════════════════════════════════════════════════════════════════════════════

    Request: GET /orders (or /profile/orders)
         │
         │ middleware: auth
         │
         ↓
    ┌──────────┐
    │   User   │ Auth::user() → User id = 5
    └──────────┘


STEP 2: QUERY ORDERS FOR USER
═══════════════════════════════════════════════════════════════════════════════

    Query: SELECT * FROM orders WHERE user_id = 5 ORDER BY created_at DESC
         │
         ↓
    ┌─────────────────────────────────────────────────────────────────┐
    │  Orders Table Results                                           │
    ├─────────────────────────────────────────────────────────────────┤
    │ id  │ user_id │ public_id         │ total_amount │ status      │
    ├─────┼─────────┼───────────────────┼──────────────┼─────────────┤
    │ 500 │   5     │ ORD-20250102-XYZ  │   145.00     │ completed   │
    │ 485 │   5     │ ORD-20250101-ABC  │   89.50      │ processing  │
    │ 470 │   5     │ ORD-20241230-DEF  │   210.00     │ shipped     │
    │ 455 │   5     │ ORD-20241228-GHI  │   45.00      │ completed   │
    └─────────────────────────────────────────────────────────────────┘


STEP 3: EAGER LOAD ORDER ITEMS
═══════════════════════════════════════════════════════════════════════════════

    Query: SELECT * FROM order_items WHERE order_id IN (500, 485, 470, 455)
         │
         ↓
    ┌──────────────────────────────────────────────────────────────────────┐
    │  Order_Items Table Results                                           │
    ├──────────────────────────────────────────────────────────────────────┤
    │ id  │ order_id │ book_id │ quantity │ price   │ cost_price │ subtotal│
    ├─────┼──────────┼─────────┼──────────┼─────────┼────────────┼─────────┤
    │ 1   │   500    │   42    │    2     │  75.00  │   50.00    │ 150.00  │
    │ 2   │   500    │   55    │    1     │  50.00  │   35.00    │  50.00  │
    │ 3   │   485    │   78    │    1     │  89.50  │   60.00    │  89.50  │
    │ 4   │   470    │   42    │    3     │  70.00  │   50.00    │ 210.00  │
    │ 5   │   470    │   91    │    1     │  35.00  │   20.00    │  35.00  │
    │ 6   │   455    │   15    │    1     │  45.00  │   30.00    │  45.00  │
    └──────────────────────────────────────────────────────────────────────┘


STEP 4: EAGER LOAD BOOKS
═══════════════════════════════════════════════════════════════════════════════

    Query: SELECT * FROM books WHERE id IN (42, 55, 78, 91, 15)
         │
         ↓
    ┌──────────────────────────────────────────────────────────────────────────┐
    │  Books Table Results                                                     │
    ├──────────────────────────────────────────────────────────────────────────┤
    │ id │ title                  │ author        │ slug            │ cover_img│
    ├────┼────────────────────────┼───────────────┼─────────────────┼──────────┤
    │ 42 │ The Great Adventure    │ John Smith    │ great-adventure │ img1.jpg │
    │ 55 │ Mystery Tales          │ Jane Doe      │ mystery-tales   │ img2.jpg │
    │ 78 │ Science Fiction World  │ Bob Johnson   │ scifi-world     │ img3.jpg │
    │ 91 │ Romance Stories        │ Alice Brown   │ romance-stories │ img4.jpg │
    │ 15 │ Thriller Novel         │ Charlie White │ thriller-novel  │ img5.jpg │
    └──────────────────────────────────────────────────────────────────────────┘


STEP 5: COMBINE DATA (Laravel does this automatically with eager loading)
═══════════════════════════════════════════════════════════════════════════════

    Result: Collection of Order objects, each with:
         │
         ├─► Order properties (public_id, total_amount, status, etc.)
         ├─► items[] → Collection of OrderItem objects
         │       └─► Each has book → Book object
         │
         └─► Ready for display in view


STEP 6: RENDER VIEW
═══════════════════════════════════════════════════════════════════════════════

    Pass to view: @foreach($orders as $order)
         │
         ├─► Display: order.public_id, order.total_amount, order.status
         │
         └─► For each order.items:
                 Display: item.book.title, item.quantity, item.price
```

---

## Laravel Query Examples

### Basic Order History Query

```php
// app/Http/Controllers/OrderController.php

public function index()
{
    $user = Auth::user();
    
    // Basic query - retrieve user's orders
    $orders = Order::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('orders.index', compact('orders'));
}
```

### Optimized Query with Eager Loading

```php
// app/Http/Controllers/OrderController.php

public function index()
{
    $user = Auth::user();
    
    // Optimized query - prevent N+1 problem
    $orders = Order::where('user_id', $user->id)
        ->with([
            'items.book' // Eager load order items and their books
        ])
        ->orderBy('created_at', 'desc')
        ->get();
    
    return view('orders.index', compact('orders'));
}
```

### Advanced Query with Pagination

```php
// app/Http/Controllers/OrderController.php

public function index()
{
    $user = Auth::user();
    
    // With pagination and additional relationships
    $orders = Order::where('user_id', $user->id)
        ->with([
            'items.book:id,title,slug,author,cover_image', // Select specific columns
            'postageRateHistory:id,region,state,customer_price'
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(10); // Show 10 orders per page
    
    return view('orders.index', compact('orders'));
}
```

### Query with Filters

```php
// app/Http/Controllers/OrderController.php

public function index(Request $request)
{
    $user = Auth::user();
    
    // Build query
    $query = Order::where('user_id', $user->id);
    
    // Filter by status
    if ($request->has('status') && $request->status !== 'all') {
        $query->where('status', $request->status);
    }
    
    // Filter by payment status
    if ($request->has('payment_status')) {
        $query->where('payment_status', $request->payment_status);
    }
    
    // Filter by date range
    if ($request->has('from_date')) {
        $query->whereDate('created_at', '>=', $request->from_date);
    }
    
    if ($request->has('to_date')) {
        $query->whereDate('created_at', '<=', $request->to_date);
    }
    
    // Search by order ID
    if ($request->has('search')) {
        $query->where('public_id', 'like', '%' . $request->search . '%');
    }
    
    // Execute query with eager loading
    $orders = $query
        ->with(['items.book'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);
    
    return view('orders.index', compact('orders'));
}
```

### Single Order Details Query

```php
// app/Http/Controllers/OrderController.php

public function show($publicId)
{
    $user = Auth::user();
    
    // Retrieve single order with all details
    $order = Order::where('public_id', $publicId)
        ->where('user_id', $user->id) // Security: ensure order belongs to user
        ->with([
            'items.book.genres',
            'items.book.tropes',
            'postageRateHistory'
        ])
        ->firstOrFail(); // 404 if not found
    
    return view('orders.show', compact('order'));
}
```

### Model Relationships

```php
// app/Models/Order.php

class Order extends Model
{
    /**
     * Get the user that owns the order
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the order items for the order
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * Get the postage rate history record
     */
    public function postageRateHistory()
    {
        return $this->belongsTo(PostageRateHistory::class, 'postage_rate_history_id');
    }
    
    /**
     * Calculate subtotal (sum of all items)
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
    
    /**
     * Get final shipping cost (may be 0 if free shipping)
     */
    public function getShippingCostAttribute()
    {
        return $this->is_free_shipping ? 0 : $this->shipping_customer_price;
    }
}
```

```php
// app/Models/OrderItem.php

class OrderItem extends Model
{
    /**
     * Get the order that owns the item
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    /**
     * Get the book for this item
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    
    /**
     * Calculate item subtotal
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}
```

```php
// app/Models/User.php

class User extends Model
{
    /**
     * Get all orders for the user
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    /**
     * Get recent orders (last 5)
     */
    public function recentOrders()
    {
        return $this->hasMany(Order::class)
            ->orderBy('created_at', 'desc')
            ->limit(5);
    }
    
    /**
     * Get completed orders only
     */
    public function completedOrders()
    {
        return $this->hasMany(Order::class)
            ->where('status', 'completed');
    }
}
```

---

## Order List Page

### View Example

```blade
{{-- resources/views/orders/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Orders</h1>
    
    {{-- Filter Form --}}
    <div class="filters mb-4">
        <form method="GET" action="{{ route('orders.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="all">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}" placeholder="From Date">
                </div>
                <div class="col-md-3">
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}" placeholder="To Date">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
    
    {{-- Orders List --}}
    @if($orders->isEmpty())
        <div class="alert alert-info">
            You haven't placed any orders yet.
            <a href="{{ route('books.index') }}">Start shopping</a>
        </div>
    @else
        @foreach($orders as $order)
            <div class="order-card card mb-3">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Order #{{ $order->public_id }}</strong>
                        </div>
                        <div class="col-md-4">
                            <span class="badge badge-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                                Payment: {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <div class="col-md-4 text-right">
                            <small>{{ $order->created_at->format('d M Y, H:i') }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    {{-- Order Items --}}
                    <div class="order-items">
                        @foreach($order->items as $item)
                            <div class="row mb-2">
                                <div class="col-md-2">
                                    <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                         alt="{{ $item->book->title }}" 
                                         class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ $item->book->title }}</h6>
                                    <small>by {{ $item->book->author }}</small>
                                </div>
                                <div class="col-md-2">
                                    <p>Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="col-md-2 text-right">
                                    <p>RM {{ number_format($item->price, 2) }}</p>
                                    <small>Subtotal: RM {{ number_format($item->subtotal, 2) }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    {{-- Order Summary --}}
                    <div class="row mt-3 pt-3 border-top">
                        <div class="col-md-8">
                            <a href="{{ route('orders.show', $order->public_id) }}" class="btn btn-sm btn-primary">
                                View Details
                            </a>
                            
                            @if($order->status == 'pending' && $order->payment_status == 'pending')
                                <a href="{{ $order->toyyibpay_payment_url }}" class="btn btn-sm btn-warning" target="_blank">
                                    Pay Now
                                </a>
                            @endif
                        </div>
                        <div class="col-md-4 text-right">
                            <p><strong>Total: RM {{ number_format($order->total_amount, 2) }}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        {{-- Pagination --}}
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
```

---

## Order Details Page

### Controller Method

```php
// app/Http/Controllers/OrderController.php

public function show($publicId)
{
    $user = Auth::user();
    
    $order = Order::where('public_id', $publicId)
        ->where('user_id', $user->id)
        ->with([
            'items.book',
            'postageRateHistory'
        ])
        ->firstOrFail();
    
    return view('orders.show', compact('order'));
}
```

### View Example

```blade
{{-- resources/views/orders/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2>Order Details</h2>
            
            {{-- Order Info --}}
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Order ID:</strong> {{ $order->public_id }}</p>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge badge-{{ $order->status == 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Payment Status:</strong> 
                                <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                            @if($order->payment_date)
                                <p><strong>Payment Date:</strong> {{ $order->payment_date->format('d M Y, H:i') }}</p>
                            @endif
                            @if($order->toyyibpay_bill_code)
                                <p><strong>Bill Code:</strong> {{ $order->toyyibpay_bill_code }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Order Items --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Order Items</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                                 alt="{{ $item->book->title }}" 
                                                 style="width: 50px; height: 75px; object-fit: cover;"
                                                 class="mr-3">
                                            <div>
                                                <a href="{{ route('books.show', $item->book->slug) }}">
                                                    {{ $item->book->title }}
                                                </a>
                                                <br>
                                                <small>by {{ $item->book->author }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>RM {{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>RM {{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Shipping Address --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Shipping Address</h5>
                </div>
                <div class="card-body">
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_postal_code }} {{ $order->shipping_city }}</p>
                    <p>{{ $order->shipping_state }}</p>
                    <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                </div>
            </div>
        </div>
        
        {{-- Order Summary Sidebar --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td>Subtotal:</td>
                            <td class="text-right">RM {{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        
                        @if($order->discount_amount > 0)
                            <tr>
                                <td>Discount:</td>
                                <td class="text-right text-success">
                                    -RM {{ number_format($order->discount_amount, 2) }}
                                    @if($order->coupon_code)
                                        <br><small>({{ $order->coupon_code }})</small>
                                    @endif
                                </td>
                            </tr>
                        @endif
                        
                        <tr>
                            <td>Shipping:</td>
                            <td class="text-right">
                                @if($order->is_free_shipping)
                                    <span class="text-success">FREE</span>
                                @else
                                    RM {{ number_format($order->shipping_customer_price, 2) }}
                                @endif
                            </td>
                        </tr>
                        
                        <tr class="border-top">
                            <td><strong>Total:</strong></td>
                            <td class="text-right"><strong>RM {{ number_format($order->total_amount, 2) }}</strong></td>
                        </tr>
                    </table>
                    
                    @if($order->status == 'pending' && $order->payment_status == 'pending')
                        <a href="{{ $order->toyyibpay_payment_url }}" class="btn btn-warning btn-block" target="_blank">
                            Complete Payment
                        </a>
                    @endif
                    
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary btn-block">
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

---

## Performance Optimization

### 1. Eager Loading (Prevent N+1 Queries)

```php
// BAD: N+1 Query Problem
$orders = Order::where('user_id', $userId)->get();
foreach ($orders as $order) {
    foreach ($order->items as $item) { // Additional query for EACH order
        echo $item->book->title; // Additional query for EACH item
    }
}
// Total queries: 1 (orders) + N (items per order) + N*M (books per item) = 1 + 10 + 30 = 41 queries!

// GOOD: Eager Loading
$orders = Order::where('user_id', $userId)
    ->with(['items.book']) // Load all relationships upfront
    ->get();
foreach ($orders as $order) {
    foreach ($order->items as $item) {
        echo $item->book->title; // No additional query!
    }
}
// Total queries: 3 (orders, order_items, books) = Fast!
```

### 2. Select Only Needed Columns

```php
// Instead of loading all book columns
$orders = Order::where('user_id', $userId)
    ->with(['items.book'])
    ->get();

// Select only required columns
$orders = Order::where('user_id', $userId)
    ->with(['items.book:id,title,slug,author,cover_image,price'])
    ->get();
// Reduces memory usage and data transfer
```

### 3. Pagination for Large Lists

```php
// Instead of loading all orders at once
$orders = Order::where('user_id', $userId)
    ->with(['items.book'])
    ->orderBy('created_at', 'desc')
    ->get(); // May load 1000+ orders!

// Use pagination
$orders = Order::where('user_id', $userId)
    ->with(['items.book'])
    ->orderBy('created_at', 'desc')
    ->paginate(15); // Load only 15 at a time
```

### 4. Caching Recent Orders

```php
use Illuminate\Support\Facades\Cache;

public function recentOrders()
{
    $userId = Auth::id();
    
    // Cache for 10 minutes
    $orders = Cache::remember("user.{$userId}.recent_orders", 600, function () use ($userId) {
        return Order::where('user_id', $userId)
            ->with(['items.book:id,title,slug,cover_image'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    });
    
    return $orders;
}
```

### 5. Database Indexing

```php
// database/migrations/xxxx_add_indexes_to_orders_table.php

public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->index('user_id'); // Fast lookup by user
        $table->index('status'); // Fast filtering by status
        $table->index('payment_status'); // Fast filtering by payment status
        $table->index('created_at'); // Fast ordering by date
        $table->index(['user_id', 'created_at']); // Composite index for user + date queries
    });
    
    Schema::table('order_items', function (Blueprint $table) {
        $table->index('order_id'); // Fast JOIN with orders
        $table->index('book_id'); // Fast JOIN with books
    });
}
```

---

## Complete SQL Examples

### Query 1: Get All User Orders with Items

```sql
-- Step 1: Get orders for user
SELECT 
    o.id,
    o.user_id,
    o.public_id,
    o.total_amount,
    o.status,
    o.payment_status,
    o.discount_amount,
    o.coupon_code,
    o.is_free_shipping,
    o.shipping_customer_price,
    o.shipping_address,
    o.shipping_city,
    o.shipping_state,
    o.created_at,
    o.payment_date
FROM orders o
WHERE o.user_id = 5
ORDER BY o.created_at DESC;

-- Step 2: Get order items for those orders
SELECT 
    oi.id,
    oi.order_id,
    oi.book_id,
    oi.quantity,
    oi.price,
    oi.cost_price
FROM order_items oi
WHERE oi.order_id IN (500, 485, 470, 455, 440); -- Order IDs from Step 1

-- Step 3: Get book details for those items
SELECT 
    b.id,
    b.title,
    b.slug,
    b.author,
    b.cover_image,
    b.price AS current_price
FROM books b
WHERE b.id IN (42, 55, 78, 91, 15); -- Book IDs from Step 2
```

### Query 2: Single Order with Full Details

```sql
-- Get complete order details
SELECT 
    o.*,
    prh.region,
    prh.state AS postage_state,
    prh.customer_price AS postage_customer_price,
    prh.actual_cost AS postage_actual_cost
FROM orders o
LEFT JOIN postage_rate_history prh ON o.postage_rate_history_id = prh.id
WHERE o.public_id = 'ORD-20250102-XYZ123'
  AND o.user_id = 5;

-- Get order items with book details
SELECT 
    oi.id,
    oi.order_id,
    oi.quantity,
    oi.price AS purchase_price,
    oi.cost_price,
    b.id AS book_id,
    b.title,
    b.slug,
    b.author,
    b.cover_image,
    b.price AS current_price,
    (oi.quantity * oi.price) AS item_subtotal
FROM order_items oi
INNER JOIN books b ON oi.book_id = b.id
WHERE oi.order_id = 500; -- From previous query
```

### Query 3: Order Statistics for User

```sql
-- Get user's order statistics
SELECT 
    COUNT(*) AS total_orders,
    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_orders,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_orders,
    SUM(total_amount) AS total_spent,
    AVG(total_amount) AS average_order_value,
    MAX(created_at) AS last_order_date
FROM orders
WHERE user_id = 5;

-- Get most purchased books by user
SELECT 
    b.id,
    b.title,
    b.author,
    SUM(oi.quantity) AS total_quantity_purchased,
    COUNT(DISTINCT oi.order_id) AS times_purchased
FROM order_items oi
INNER JOIN books b ON oi.book_id = b.id
INNER JOIN orders o ON oi.order_id = o.id
WHERE o.user_id = 5
  AND o.status = 'completed'
GROUP BY b.id, b.title, b.author
ORDER BY total_quantity_purchased DESC
LIMIT 10;
```

---

## Data Presentation

### Order Status Badges

```php
// Helper function for status badge color
function getStatusBadgeClass($status)
{
    return match($status) {
        'pending' => 'badge-warning',
        'processing' => 'badge-info',
        'shipped' => 'badge-primary',
        'completed' => 'badge-success',
        'cancelled' => 'badge-secondary',
        'failed' => 'badge-danger',
        default => 'badge-secondary',
    };
}

function getPaymentStatusBadgeClass($paymentStatus)
{
    return match($paymentStatus) {
        'paid' => 'badge-success',
        'pending' => 'badge-warning',
        'failed' => 'badge-danger',
        default => 'badge-secondary',
    };
}
```

### Price Comparison Display

```blade
{{-- Show if current price differs from purchase price --}}
@foreach($order->items as $item)
    <div>
        <p>Purchase Price: RM {{ number_format($item->price, 2) }}</p>
        
        @if($item->book->price != $item->price)
            <p class="text-muted">
                Current Price: RM {{ number_format($item->book->price, 2) }}
                @if($item->book->price < $item->price)
                    <span class="text-success">(Price decreased)</span>
                @else
                    <span class="text-danger">(Price increased)</span>
                @endif
            </p>
        @endif
    </div>
@endforeach
```

### Order Timeline

```blade
<div class="order-timeline">
    <div class="timeline-item {{ $order->created_at ? 'active' : '' }}">
        <span class="timeline-icon">✓</span>
        <span>Order Placed</span>
        <small>{{ $order->created_at->format('d M Y, H:i') }}</small>
    </div>
    
    <div class="timeline-item {{ $order->payment_date ? 'active' : '' }}">
        <span class="timeline-icon">{{ $order->payment_date ? '✓' : '○' }}</span>
        <span>Payment Confirmed</span>
        @if($order->payment_date)
            <small>{{ $order->payment_date->format('d M Y, H:i') }}</small>
        @endif
    </div>
    
    <div class="timeline-item {{ $order->status == 'shipped' || $order->status == 'completed' ? 'active' : '' }}">
        <span class="timeline-icon">{{ $order->status == 'shipped' || $order->status == 'completed' ? '✓' : '○' }}</span>
        <span>Shipped</span>
    </div>
    
    <div class="timeline-item {{ $order->status == 'completed' ? 'active' : '' }}">
        <span class="timeline-icon">{{ $order->status == 'completed' ? '✓' : '○' }}</span>
        <span>Delivered</span>
    </div>
</div>
```

---

## Key Points Summary

### 1. **User-Scoped Queries**
```php
Order::where('user_id', Auth::id()) // ALWAYS filter by user!
```

### 2. **Eager Loading is Critical**
```php
->with(['items.book']) // Prevent N+1 queries
```

### 3. **Security Check**
```php
// Always verify order belongs to authenticated user
$order = Order::where('public_id', $publicId)
    ->where('user_id', Auth::id())
    ->firstOrFail();
```

### 4. **Snapshot Prices Preserved**
- `order_items.price` = Price at purchase time (may differ from current `books.price`)
- `order_items.cost_price` = Cost at purchase time
- Important for accurate historical records

### 5. **Related Entities**
- **Orders** → User, PostageRateHistory
- **OrderItems** → Order, Book
- **Books** → Current data (for linking back to product pages)

---

## Complete Retrieval Flow Diagram

```
┌═══════════════════════════════════════════════════════════════════════════════┐
║                   PURCHASE HISTORY RETRIEVAL SUMMARY                          ║
└═══════════════════════════════════════════════════════════════════════════════┘

    User visits /orders page
            │
            ↓
    [Middleware: auth]
            │
            ↓
    OrderController@index
            │
            ├─► Query: SELECT * FROM orders WHERE user_id = 5 ORDER BY created_at DESC
            │
            ├─► Eager Load: SELECT * FROM order_items WHERE order_id IN (...)
            │
            ├─► Eager Load: SELECT * FROM books WHERE id IN (...)
            │
            └─► Return Collection<Order> with loaded relationships
                    │
                    └─► Each Order has:
                            • properties (public_id, total, status, etc.)
                            • items[] → Collection<OrderItem>
                                  └─► Each OrderItem has:
                                          • properties (quantity, price, etc.)
                                          • book → Book object
            ↓
    Pass to view: orders/index.blade.php
            │
            ├─► @foreach($orders as $order)
            │       Display order summary
            │       @foreach($order->items as $item)
            │           Display book details from $item->book
            │
            └─► Pagination links
```

---

## Files Referenced

- `app/Models/Order.php` - Order model with relationships
- `app/Models/OrderItem.php` - OrderItem model
- `app/Models/User.php` - User model with orders relationship
- `app/Http/Controllers/OrderController.php` - Order history controller
- `resources/views/orders/index.blade.php` - Order list view
- `resources/views/orders/show.blade.php` - Order details view
- `routes/web.php` - Order routes definition

---

**Document Created**: 2025-01-02  
**System**: Bookty E-Commerce Platform  
**Purpose**: Guide for retrieving and displaying purchase history
