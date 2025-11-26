@extends('layouts.admin')

@section('title', 'User Recommendation Details')

@section('content')
<div class="container-fluid">
    <!-- Enhanced Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                <i class="fas fa-user-chart text-primary mr-2"></i>
                User Recommendation Analysis
            </h1>
            <p class="text-muted mb-0">Detailed analysis and insights for {{ $user->name }}</p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.recommendations.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-chart-line mr-1"></i> Analytics Dashboard
            </a>
            <button class="btn btn-primary" onclick="refreshUserAnalysis()">
                <i class="fas fa-sync-alt mr-1"></i> Refresh Analysis
            </button>
        </div>
    </div>

    <!-- Enhanced User Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 60px; height: 60px;">
                                    <i class="fas fa-user fa-2x text-white"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-1">{{ $user->name }}</h5>
                                    <p class="card-text text-muted mb-0">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="text-center p-3 bg-light rounded">
                                        <i class="fas fa-calendar-alt text-primary fa-2x mb-2"></i>
                                        <div class="font-weight-bold">{{ $user->created_at->format('M Y') }}</div>
                                        <small class="text-muted">Member Since</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center p-3 bg-light rounded">
                                        <i class="fas fa-shopping-cart text-success fa-2x mb-2"></i>
                                        <div class="font-weight-bold">{{ $userOrders->count() }}</div>
                                        <small class="text-muted">Total Orders</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center p-3 bg-light rounded">
                                        <i class="fas fa-book text-info fa-2x mb-2"></i>
                                        <div class="font-weight-bold">{{ $userOrders->sum(function($order) { return $order->items->sum('quantity'); }) }}</div>
                                        <small class="text-muted">Books Purchased</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center p-3 bg-light rounded">
                                        <i class="fas fa-heart text-danger fa-2x mb-2"></i>
                                        <div class="font-weight-bold">{{ $userWishlist->count() }}</div>
                                        <small class="text-muted">Wishlist Items</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <div class="badge badge-success badge-lg mb-2">Active Customer</div>
                            <div class="badge badge-primary badge-lg">Recommendation Ready</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Enhanced User Preferences -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-heart mr-2"></i>User Preferences
                    </h6>
                    <div class="badge badge-info">AI Analyzed</div>
                </div>
                <div class="card-body">
                    <!-- Favorite Genres -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-tags text-primary mr-2"></i>
                            <h6 class="text-gray-800 mb-0">Favorite Genres</h6>
                        </div>
                        @forelse($userPreferences['genres'] as $genre => $count)
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded {{ $loop->index % 2 == 0 ? 'bg-light' : '' }}">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 30px; height: 30px;">
                                        <span class="text-white font-weight-bold small">{{ $loop->index + 1 }}</span>
                                    </div>
                                    <span class="font-weight-bold">{{ $genre }}</span>
                                </div>
                                <span class="badge badge-primary badge-lg">{{ $count }} books</span>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <i class="fas fa-tags text-gray-300 fa-2x mb-2"></i>
                                <p class="text-muted small mb-0">No genre preferences yet</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <hr class="my-3">
                    
                    <!-- Favorite Authors -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-user-edit text-success mr-2"></i>
                            <h6 class="text-gray-800 mb-0">Favorite Authors</h6>
                        </div>
                        @forelse($userPreferences['authors'] as $author => $count)
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded {{ $loop->index % 2 == 0 ? 'bg-light' : '' }}">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 30px; height: 30px;">
                                        <span class="text-white font-weight-bold small">{{ $loop->index + 1 }}</span>
                                    </div>
                                    <span class="font-weight-bold">{{ $author }}</span>
                                </div>
                                <span class="badge badge-success badge-lg">{{ $count }} books</span>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <i class="fas fa-user-edit text-gray-300 fa-2x mb-2"></i>
                                <p class="text-muted small mb-0">No author preferences yet</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <hr class="my-3">
                    
                    <!-- Favorite Tropes -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-magic text-info mr-2"></i>
                            <h6 class="text-gray-800 mb-0">Favorite Tropes</h6>
                        </div>
                        @forelse($userPreferences['tropes'] as $trope => $count)
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 rounded {{ $loop->index % 2 == 0 ? 'bg-light' : '' }}">
                                <div class="d-flex align-items-center">
                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 30px; height: 30px;">
                                        <span class="text-white font-weight-bold small">{{ $loop->index + 1 }}</span>
                                    </div>
                                    <span class="font-weight-bold">{{ $trope }}</span>
                                </div>
                                <span class="badge badge-info badge-lg">{{ $count }} books</span>
                            </div>
                        @empty
                            <div class="text-center py-3">
                                <i class="fas fa-magic text-gray-300 fa-2x mb-2"></i>
                                <p class="text-muted small mb-0">No trope preferences yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Current Recommendations -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-star mr-2"></i>Current Recommendations
                    </h6>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary active">All</button>
                        <button class="btn btn-outline-primary">High Score</button>
                        <button class="btn btn-outline-primary">New</button>
                    </div>
                </div>
                <div class="card-body">
                    @if($userRecommendations->count() > 0)
                        <div class="row">
                            @foreach($userRecommendations as $book)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-left-primary h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                @if($book->cover_image)
                                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                                         class="mr-3 rounded shadow-sm" width="60" height="80" style="object-fit: cover;">
                                                @else
                                                    <div class="mr-3 bg-light rounded d-flex align-items-center justify-content-center shadow-sm" 
                                                         style="width: 60px; height: 80px;">
                                                        <i class="fas fa-book text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 font-weight-bold">{{ $book->title }}</h6>
                                                    <p class="text-muted small mb-2">by {{ $book->author }}</p>
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="badge badge-secondary">{{ $book->genre->name ?? 'N/A' }}</span>
                                                        @if(isset($book->score))
                                                            <div class="d-flex align-items-center">
                                                                <div class="progress mr-2" style="width: 60px; height: 6px;">
                                                                    <div class="progress-bar bg-success" style="width: {{ $book->score * 100 }}%"></div>
                                                                </div>
                                                                <span class="badge badge-success">{{ round($book->score * 100) }}%</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <small class="text-muted">RM {{ number_format($book->price, 2) }}</small>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary btn-sm" title="View Book">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <button class="btn btn-outline-success btn-sm" title="Add to Cart">
                                                                <i class="fas fa-cart-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-4x text-gray-300 mb-4"></i>
                            <h5 class="text-gray-600 mb-3">No Recommendations Available</h5>
                            <p class="text-muted mb-4">This user needs more purchase history for accurate recommendations.</p>
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <strong>Cold Start Problem:</strong> Users with limited purchase history require different recommendation strategies.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Purchase History -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-shopping-cart mr-2"></i>Purchase History
                    </h6>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary active">All Orders</button>
                        <button class="btn btn-outline-primary">Completed</button>
                        <button class="btn btn-outline-primary">Recent</button>
                    </div>
                </div>
                <div class="card-body">
                    @if($userOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Order Date</th>
                                        <th>Books</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userOrders as $order)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                                    <div>
                                                        <div class="font-weight-bold">{{ $order->created_at->format('M d, Y') }}</div>
                                                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach($order->items as $item)
                                                    <div class="d-flex align-items-center mb-2 p-2 rounded {{ $loop->index % 2 == 0 ? 'bg-light' : '' }}">
                                                        @if($item->book->cover_image)
                                                            <img src="{{ asset('storage/' . $item->book->cover_image) }}" 
                                                                 class="mr-3 rounded shadow-sm" width="40" height="50" style="object-fit: cover;">
                                                        @else
                                                            <div class="mr-3 bg-light rounded d-flex align-items-center justify-content-center shadow-sm" 
                                                                 style="width: 40px; height: 50px;">
                                                                <i class="fas fa-book text-gray-400" style="font-size: 14px;"></i>
                                                            </div>
                                                        @endif
                                                        <div class="flex-grow-1">
                                                            <div class="font-weight-bold small">{{ $item->book->title }}</div>
                                                            <small class="text-muted">by {{ $item->book->author }}</small>
                                                            <div class="d-flex justify-content-between align-items-center mt-1">
                                                                <span class="badge badge-secondary">{{ $item->book->genre->name ?? 'N/A' }}</span>
                                                                <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <div class="font-weight-bold text-success">RM {{ number_format($order->total_amount, 2) }}</div>
                                                    <small class="text-muted">{{ $order->items->sum('quantity') }} items</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }} badge-lg">
                                                    <i class="fas fa-{{ $order->status === 'completed' ? 'check-circle' : ($order->status === 'pending' ? 'clock' : 'info-circle') }} mr-1"></i>
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-primary" title="View Order">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-info" title="Edit Order">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-gray-300 mb-4"></i>
                            <h5 class="text-gray-600 mb-3">No Purchase History</h5>
                            <p class="text-muted mb-4">This user hasn't made any purchases yet.</p>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <strong>New User:</strong> Consider showing popular books or new arrivals to encourage first purchase.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Wishlist -->
    @if($userWishlist->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-heart mr-2"></i>Wishlist
                        </h6>
                        <div class="badge badge-danger badge-lg">{{ $userWishlist->count() }} items</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($userWishlist as $book)
                                <div class="col-md-3 mb-3">
                                    <div class="card border-left-danger h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-start">
                                                @if($book->cover_image)
                                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                                         class="mr-3 rounded shadow-sm" width="50" height="70" style="object-fit: cover;">
                                                @else
                                                    <div class="mr-3 bg-light rounded d-flex align-items-center justify-content-center shadow-sm" 
                                                         style="width: 50px; height: 70px;">
                                                        <i class="fas fa-book text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 font-weight-bold small">{{ $book->title }}</h6>
                                                    <p class="text-muted small mb-2">by {{ $book->author }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge badge-secondary">{{ $book->genre->name ?? 'N/A' }}</span>
                                                        <small class="text-success font-weight-bold">RM {{ number_format($book->price, 2) }}</small>
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="btn-group btn-group-sm w-100">
                                                            <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary btn-sm" title="View Book">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <button class="btn btn-outline-success btn-sm" title="Add to Cart">
                                                                <i class="fas fa-cart-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function refreshUserAnalysis() {
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Refreshing...';
    btn.disabled = true;
    
    // Simulate refresh
    setTimeout(() => {
        location.reload();
    }, 1500);
}

// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on hover
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Add click handlers for filter buttons
    const filterButtons = document.querySelectorAll('.btn-group-sm button');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from siblings
            this.parentElement.querySelectorAll('button').forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
        });
    });
});
</script>

<style>
.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.border-left-primary {
    border-left: 4px solid #4e73df !important;
}

.border-left-danger {
    border-left: 4px solid #e74a3b !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.btn-group-sm button.active {
    background-color: #4e73df;
    border-color: #4e73df;
    color: white;
}

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}
</style>
