# Audit Trail Pattern: Complaint System vs E-Commerce Pricing

## 🎯 Overview

This document analyzes the audit trail pattern used in your **Complaint Management System** and shows how the same pattern can be applied to the **E-Commerce Pricing System**.

**Key Insight**: You've already successfully implemented **Solution 2: History Table** in your complaint system! The same pattern can be used for tracking price changes.

---

## 📊 Side-by-Side Comparison

### Your Complaint System (Already Implemented ✅)

```
┌─────────────────────┐         ┌──────────────────────────┐
│    complaints       │         │ complaint_status_logs    │
│  (Current State)    │         │   (Audit History)        │
├─────────────────────┤         ├──────────────────────────┤
│ id                  │         │ id                       │
│ public_id           │◄────────│ complaint_id (FK)        │
│ name                │         │ status                   │
│ status (current)    │         │ updated_by (FK to users) │
│ phone               │         │ comment                  │
│ created_at          │         │ created_at               │
│ updated_at          │         │ (NO updated_at)          │
└─────────────────────┘         └──────────────────────────┘
     Current Status                   History Trail
     (can change)                    (immutable log)
```

### E-Commerce Pricing (Proposed Pattern)

```
┌─────────────────────┐         ┌──────────────────────────┐
│   postage_rates     │         │ postage_rate_history     │
│  (Current Rates)    │         │   (Price History)        │
├─────────────────────┤         ├──────────────────────────┤
│ id                  │         │ id                       │
│ region              │◄────────│ postage_rate_id (FK)     │
│ customer_price      │         │ customer_price           │
│ actual_cost         │         │ actual_cost              │
│ created_at          │         │ updated_by (FK to users) │
│ updated_at          │         │ comment                  │
└─────────────────────┘         │ valid_from               │
     Current Prices              │ valid_until              │
     (can change)                │ created_at               │
                                 │ (NO updated_at)          │
                                 └──────────────────────────┘
                                      History Trail
                                     (immutable log)
```

---

## 🔍 Pattern Analysis

### Complaint System Architecture

```php
// Your Current Implementation

// 1. MAIN TABLE: complaints (current state)
class Complaint extends Model
{
    protected $fillable = [
        'public_id',
        'name',
        'status', // Current status only
        'phone',
        // ... other fields
    ];
    
    // Relationship to audit logs
    public function statusLogs()
    {
        return $this->hasMany(ComplaintStatusLog::class);
    }
}

// 2. AUDIT TABLE: complaint_status_logs (history)
class ComplaintStatusLog extends Model
{
    protected $fillable = [
        'complaint_id',
        'status',
        'updated_by',
        'comment',
    ];
    
    const UPDATED_AT = null; // Immutable - no updates!
    
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }
    
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

// 3. USAGE: When status changes
public function updateStatus($complaintId, $newStatus, $comment = null)
{
    $complaint = Complaint::findOrFail($complaintId);
    
    // Only log if status actually changed
    if ($complaint->status !== $newStatus) {
        // Update current status
        $complaint->update(['status' => $newStatus]);
        
        // Create immutable audit record
        ComplaintStatusLog::create([
            'complaint_id' => $complaint->id,
            'status' => $newStatus,
            'updated_by' => auth()->id(),
            'comment' => $comment,
        ]);
    }
}

// 4. RETRIEVAL: Get history timeline
public function getStatusHistory($complaintId)
{
    return ComplaintStatusLog::where('complaint_id', $complaintId)
        ->with('updater')
        ->orderBy('created_at', 'desc')
        ->get();
}
```

### Applied to E-Commerce Pricing

```php
// Same Pattern Applied to Pricing

// 1. MAIN TABLE: postage_rates (current rates)
class PostageRate extends Model
{
    protected $fillable = [
        'region',
        'customer_price',
        'actual_cost',
    ];
    
    // Relationship to history
    public function priceHistory()
    {
        return $this->hasMany(PostageRateHistory::class);
    }
    
    // Get current active history record
    public function currentHistory()
    {
        return $this->priceHistory()
            ->whereNull('valid_until')
            ->first();
    }
}

// 2. AUDIT TABLE: postage_rate_history (history)
class PostageRateHistory extends Model
{
    protected $fillable = [
        'postage_rate_id',
        'customer_price',
        'actual_cost',
        'updated_by',
        'comment',
        'valid_from',
        'valid_until',
    ];
    
    const UPDATED_AT = null; // Immutable - no updates!
    
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];
    
    public function postageRate()
    {
        return $this->belongsTo(PostageRate::class);
    }
    
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    // Scope: Get rate valid at specific time
    public function scopeValidAt($query, $datetime)
    {
        return $query->where('valid_from', '<=', $datetime)
            ->where(function($q) use ($datetime) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>', $datetime);
            });
    }
}

// 3. USAGE: When price changes
public function updatePrice($region, $newCustomerPrice, $newActualCost, $comment = null)
{
    $rate = PostageRate::where('region', $region)->first();
    
    // Only log if price actually changed
    if ($rate->customer_price != $newCustomerPrice || 
        $rate->actual_cost != $newActualCost) {
        
        // Close current history record
        PostageRateHistory::where('postage_rate_id', $rate->id)
            ->whereNull('valid_until')
            ->update(['valid_until' => now()]);
        
        // Create new history record
        PostageRateHistory::create([
            'postage_rate_id' => $rate->id,
            'customer_price' => $newCustomerPrice,
            'actual_cost' => $newActualCost,
            'updated_by' => auth()->id(),
            'comment' => $comment,
            'valid_from' => now(),
            'valid_until' => null, // Current
        ]);
        
        // Update current rate
        $rate->update([
            'customer_price' => $newCustomerPrice,
            'actual_cost' => $newActualCost,
        ]);
    }
}

// 4. RETRIEVAL: Get price at order time
public function getPriceAtOrderTime(Order $order)
{
    return PostageRateHistory::where('region', $order->shipping_region)
        ->validAt($order->created_at)
        ->first();
}

// 5. AT CHECKOUT: Link order to history
public function createOrder($cart, $shippingRegion)
{
    $currentHistory = PostageRateHistory::where('region', $shippingRegion)
        ->whereNull('valid_until')
        ->first();
    
    return Order::create([
        'user_id' => auth()->id(),
        'postage_rate_history_id' => $currentHistory->id, // Link to history!
        'shipping_region' => $shippingRegion,
        // Also denormalize for fast access
        'shipping_customer_price' => $currentHistory->customer_price,
        'shipping_actual_cost' => $currentHistory->actual_cost,
    ]);
}
```

---

## 📋 Database Schema Comparison

### Complaint Audit Schema

```sql
-- Main table (current state)
CREATE TABLE complaints (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    public_id VARCHAR(255) UNIQUE,
    name VARCHAR(255),
    status ENUM('menunggu', 'diterima', 'ditolak', 'selesai'),
    phone VARCHAR(20),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Audit/History table
CREATE TABLE complaint_status_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    complaint_id BIGINT NOT NULL,
    status ENUM('menunggu', 'diterima', 'ditolak', 'selesai'),
    updated_by BIGINT,
    comment TEXT,
    created_at TIMESTAMP,
    -- NO updated_at (immutable!)
    
    FOREIGN KEY (complaint_id) REFERENCES complaints(id),
    FOREIGN KEY (updated_by) REFERENCES users(id),
    INDEX(complaint_id, created_at)
);
```

### E-Commerce Pricing Schema (Same Pattern!)

```sql
-- Main table (current rates)
CREATE TABLE postage_rates (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    region VARCHAR(50) UNIQUE,
    customer_price DECIMAL(10,2),
    actual_cost DECIMAL(10,2),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Audit/History table (same pattern as complaint logs!)
CREATE TABLE postage_rate_history (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    postage_rate_id BIGINT NOT NULL,
    customer_price DECIMAL(10,2),
    actual_cost DECIMAL(10,2),
    updated_by BIGINT,
    comment TEXT,
    valid_from TIMESTAMP NOT NULL,
    valid_until TIMESTAMP NULL, -- NULL = current
    created_at TIMESTAMP,
    -- NO updated_at (immutable!)
    
    FOREIGN KEY (postage_rate_id) REFERENCES postage_rates(id),
    FOREIGN KEY (updated_by) REFERENCES users(id),
    INDEX(postage_rate_id, valid_from, valid_until)
);

-- Orders link to history (like complaints link to status logs)
CREATE TABLE orders (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    postage_rate_history_id BIGINT, -- FK to history record!
    shipping_region VARCHAR(50),
    -- Denormalized for performance
    shipping_customer_price DECIMAL(10,2),
    shipping_actual_cost DECIMAL(10,2),
    created_at TIMESTAMP,
    
    FOREIGN KEY (postage_rate_history_id) 
        REFERENCES postage_rate_history(id)
);
```

---

## 🎯 Key Similarities

| Feature | Complaint System | Pricing System |
|---------|-----------------|----------------|
| **Main Table** | `complaints` (current) | `postage_rates` (current) |
| **History Table** | `complaint_status_logs` | `postage_rate_history` |
| **Immutable Records** | ✅ No `updated_at` | ✅ No `updated_at` |
| **Who Changed** | `updated_by` (admin) | `updated_by` (admin) |
| **What Changed** | `status` | `customer_price`, `actual_cost` |
| **Comments** | ✅ Optional comment | ✅ Optional comment |
| **Timeline View** | ✅ Status history | ✅ Price history |
| **Links Back** | complaint → status logs | order → price history |
| **Accountability** | ✅ Track who changed | ✅ Track who changed |
| **Audit Trail** | ✅ Full history | ✅ Full history |

---

## 🔄 Pattern Comparison Diagram

```
COMPLAINT AUDIT PATTERN                    PRICING AUDIT PATTERN
=======================                    =====================

Step 1: Change Occurs                      Step 1: Change Occurs
┌─────────────────┐                        ┌─────────────────┐
│ Admin changes   │                        │ Admin changes   │
│ complaint status│                        │ shipping rate   │
└────────┬────────┘                        └────────┬────────┘
         │                                          │
Step 2: Update Main Record                 Step 2: Update Main Record
┌────────▼────────┐                        ┌────────▼────────┐
│ complaints      │                        │ postage_rates   │
│ status = new    │                        │ price = new     │
└────────┬────────┘                        └────────┬────────┘
         │                                          │
Step 3: Create Audit Log                   Step 3: Create History Record
┌────────▼────────────┐                    ┌────────▼────────────┐
│ complaint_status_   │                    │ postage_rate_       │
│ logs (NEW RECORD)   │                    │ history (NEW RECORD)│
│ - complaint_id      │                    │ - postage_rate_id   │
│ - status (new)      │                    │ - price (new)       │
│ - updated_by        │                    │ - updated_by        │
│ - comment           │                    │ - comment           │
│ - created_at        │                    │ - valid_from        │
└─────────────────────┘                    │ - valid_until       │
                                           │ - created_at        │
                                           └─────────────────────┘
Step 4: Never Updated                      Step 4: Never Updated
(Immutable Log)                            (Immutable Log)
```

---

## 💡 Hybrid Approach for Bookty (Best Solution!)

You can **combine** your complaint audit pattern with the current denormalization:

### Migration Schema

```sql
-- Step 1: Create history table (like your complaint_status_logs)
CREATE TABLE postage_rate_history (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    postage_rate_id BIGINT NOT NULL,
    customer_price DECIMAL(10,2),
    actual_cost DECIMAL(10,2),
    updated_by BIGINT,
    comment TEXT,
    valid_from TIMESTAMP NOT NULL,
    valid_until TIMESTAMP NULL,
    created_at TIMESTAMP,
    
    FOREIGN KEY (postage_rate_id) REFERENCES postage_rates(id),
    FOREIGN KEY (updated_by) REFERENCES users(id),
    INDEX(postage_rate_id, valid_from, valid_until)
);

-- Step 2: Add optional FK to orders (keep denormalization!)
ALTER TABLE orders 
ADD COLUMN postage_rate_history_id BIGINT NULL AFTER shipping_actual_cost,
ADD FOREIGN KEY (postage_rate_history_id) 
    REFERENCES postage_rate_history(id);
```

### Laravel Implementation

```php
// Model: PostageRateHistory (like ComplaintStatusLog)
class PostageRateHistory extends Model
{
    protected $fillable = [
        'postage_rate_id',
        'customer_price',
        'actual_cost',
        'updated_by',
        'comment',
        'valid_from',
        'valid_until',
    ];
    
    const UPDATED_AT = null; // Immutable like your complaint logs!
    
    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];
    
    public function postageRate()
    {
        return $this->belongsTo(PostageRate::class);
    }
    
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

// Service: Like your complaint status update
class PostageRateService
{
    public function updateRate(
        string $region, 
        float $newCustomerPrice, 
        float $newActualCost,
        ?string $comment = null
    ) {
        $rate = PostageRate::where('region', $region)->first();
        
        // Only create log if price changed (like your complaint system)
        if ($rate->customer_price != $newCustomerPrice || 
            $rate->actual_cost != $newActualCost) {
            
            // Close current history record
            PostageRateHistory::where('postage_rate_id', $rate->id)
                ->whereNull('valid_until')
                ->update(['valid_until' => now()]);
            
            // Create new history record (immutable!)
            $history = PostageRateHistory::create([
                'postage_rate_id' => $rate->id,
                'customer_price' => $newCustomerPrice,
                'actual_cost' => $newActualCost,
                'updated_by' => auth()->id(),
                'comment' => $comment,
                'valid_from' => now(),
                'valid_until' => null,
            ]);
            
            // Update current rate
            $rate->update([
                'customer_price' => $newCustomerPrice,
                'actual_cost' => $newActualCost,
            ]);
            
            return $history;
        }
        
        return null;
    }
    
    public function getCurrentHistory(string $region)
    {
        return PostageRateHistory::whereHas('postageRate', function($q) use ($region) {
                $q->where('region', $region);
            })
            ->whereNull('valid_until')
            ->first();
    }
}

// At Checkout: Link to history (keep denormalization for speed!)
public function createOrder(Cart $cart, string $shippingRegion)
{
    $historyRecord = $this->postageRateService->getCurrentHistory($shippingRegion);
    
    return Order::create([
        'user_id' => auth()->id(),
        
        // Denormalized (fast queries) ✅
        'shipping_customer_price' => $historyRecord->customer_price,
        'shipping_actual_cost' => $historyRecord->actual_cost,
        
        // History link (audit trail) ✅
        'postage_rate_history_id' => $historyRecord->id,
    ]);
}
```

### Admin View: Timeline (Like Your Complaint Timeline!)

```php
// Controller
class PostageRateHistoryController extends Controller
{
    public function index(Request $request)
    {
        $history = PostageRateHistory::with(['postageRate', 'updater'])
            ->when($request->region, function($q, $region) {
                $q->whereHas('postageRate', fn($q) => 
                    $q->where('region', $region)
                );
            })
            ->when($request->search, function($q, $search) {
                $q->whereHas('updater', fn($q) => 
                    $q->where('name', 'like', "%{$search}%")
                )
                ->orWhere('comment', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.postage-history.index', compact('history'));
    }
}
```

```blade
{{-- View: Like your complaint timeline --}}
<div class="timeline">
    @foreach($history as $log)
    <div class="timeline-item">
        <div class="timeline-marker"></div>
        <div class="timeline-content">
            <div class="flex justify-between">
                <span class="font-semibold">
                    {{ $log->updater->name ?? 'System' }}
                </span>
                <span class="text-sm text-gray-500">
                    {{ $log->created_at->format('d M Y, H:i') }}
                    <span class="text-xs">({{ $log->created_at->diffForHumans() }})</span>
                </span>
            </div>
            
            <p class="text-sm">
                Updated <strong>{{ $log->postageRate->region }}</strong> shipping rate
            </p>
            
            <div class="grid grid-cols-2 gap-4 mt-2">
                <div>
                    <span class="text-xs text-gray-500">Customer Price:</span>
                    <span class="font-semibold">RM {{ number_format($log->customer_price, 2) }}</span>
                </div>
                <div>
                    <span class="text-xs text-gray-500">Actual Cost:</span>
                    <span class="font-semibold">RM {{ number_format($log->actual_cost, 2) }}</span>
                </div>
            </div>
            
            @if($log->comment)
            <p class="text-sm text-gray-600 mt-2">
                <strong>Note:</strong> {{ $log->comment }}
            </p>
            @endif
            
            <div class="text-xs text-gray-400 mt-2">
                Valid from: {{ $log->valid_from->format('d M Y H:i') }}
                @if($log->valid_until)
                    to {{ $log->valid_until->format('d M Y H:i') }}
                @else
                    <span class="badge badge-success">Current</span>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
```

---

## 📊 Benefits of Hybrid Approach

| Benefit | Denormalization Only | History Table Only | Hybrid (Both!) ✅ |
|---------|---------------------|-------------------|------------------|
| **Fast Queries** | ✅ | ❌ | ✅ |
| **Audit Trail** | ❌ | ✅ | ✅ |
| **Timeline View** | ❌ | ✅ | ✅ |
| **Who Changed** | ❌ | ✅ | ✅ |
| **Comments/Notes** | ❌ | ✅ | ✅ |
| **No JOINs Needed** | ✅ | ❌ | ✅ |
| **Price Analysis** | ❌ | ✅ | ✅ |
| **Simple Queries** | ✅ | ❌ | ✅ |
| **Compliance Ready** | ❌ | ✅ | ✅ |

---

## 🎯 Recommended Implementation Steps

### Phase 1: Add History Table (Non-Breaking)

```bash
# Create migration
php artisan make:migration create_postage_rate_history_table
```

```php
// Migration
public function up()
{
    Schema::create('postage_rate_history', function (Blueprint $table) {
        $table->id();
        $table->foreignId('postage_rate_id')->constrained();
        $table->decimal('customer_price', 10, 2);
        $table->decimal('actual_cost', 10, 2);
        $table->foreignId('updated_by')->nullable()->constrained('users');
        $table->text('comment')->nullable();
        $table->timestamp('valid_from');
        $table->timestamp('valid_until')->nullable();
        $table->timestamp('created_at');
        
        $table->index(['postage_rate_id', 'valid_from', 'valid_until']);
    });
}
```

### Phase 2: Seed Initial History

```php
// Seed current rates as initial history
foreach (PostageRate::all() as $rate) {
    PostageRateHistory::create([
        'postage_rate_id' => $rate->id,
        'customer_price' => $rate->customer_price,
        'actual_cost' => $rate->actual_cost,
        'updated_by' => 1, // System
        'comment' => 'Initial rate',
        'valid_from' => $rate->created_at,
        'valid_until' => null, // Current
    ]);
}
```

### Phase 3: Add FK to Orders (Optional)

```php
Schema::table('orders', function (Blueprint $table) {
    $table->foreignId('postage_rate_history_id')
          ->nullable()
          ->after('shipping_actual_cost')
          ->constrained();
});
```

### Phase 4: Update Checkout Logic

```php
// In CheckoutController
public function store(Request $request)
{
    // Get current history record
    $historyRecord = PostageRateHistory::whereHas('postageRate', fn($q) =>
            $q->where('region', $request->shipping_region)
        )
        ->whereNull('valid_until')
        ->first();
    
    $order = Order::create([
        // Keep denormalization (performance)
        'shipping_customer_price' => $historyRecord->customer_price,
        'shipping_actual_cost' => $historyRecord->actual_cost,
        
        // Add history link (audit)
        'postage_rate_history_id' => $historyRecord->id,
    ]);
}
```

### Phase 5: Admin Interface

```php
// Add admin routes
Route::get('/admin/postage-rates/history', [PostageRateHistoryController::class, 'index'])
    ->name('admin.postage-history.index');

// Update rate with comment
Route::put('/admin/postage-rates/{region}', function(Request $request, $region) {
    app(PostageRateService::class)->updateRate(
        region: $region,
        newCustomerPrice: $request->customer_price,
        newActualCost: $request->actual_cost,
        comment: $request->comment // Like your complaint system!
    );
});
```

---

## 📈 Comparison Summary

### Your Complaint System ✅

```
✅ Tracks every status change
✅ Records who made change (updated_by)
✅ Optional comments
✅ Immutable records (no updated_at)
✅ Timeline view for transparency
✅ Filtering and search
✅ Links to original complaint
```

### E-Commerce with Same Pattern ✅

```
✅ Tracks every price change
✅ Records who made change (updated_by)
✅ Optional comments (why price changed)
✅ Immutable records (no updated_at)
✅ Timeline view for price history
✅ Filtering by region/time
✅ Links to original postage_rate
✅ Orders link to specific history record
```

---

## 🎯 Final Recommendation

### Current State (Denormalization Only)
```
✅ Good for: Performance
❌ Missing: Audit trail, accountability, timeline
```

### Add History Table (Like Your Complaint System!)
```
✅ Keep denormalized fields for performance
✅ Add history table for audit (same pattern you already know!)
✅ Best of both worlds
✅ Familiar pattern from your complaint system
```

### Implementation Complexity

Since you've already implemented this in your complaint system, it should be **very easy** to apply to pricing:

1. ⭐ **Easy**: You understand the pattern
2. ⭐ **Familiar**: Same code structure
3. ⭐ **Proven**: Already works in production
4. ⭐ **Tested**: Pattern validated in complaint system

---

## 📝 Conclusion

**Your complaint audit trail is an excellent example of Solution 2: History Table!**

You can apply the **exact same pattern** to track pricing changes:
- Replace `complaint_status_logs` → `postage_rate_history`
- Replace `status` → `customer_price` and `actual_cost`
- Keep same structure: `updated_by`, `comment`, immutable records
- Add timeline view (same UI as complaint history)

This gives you:
- ✅ Fast queries (denormalization)
- ✅ Full audit trail (history table)
- ✅ Accountability (who changed prices)
- ✅ Compliance (immutable records)
- ✅ Familiar pattern you already implemented!

🎉 **Best of both worlds!**
