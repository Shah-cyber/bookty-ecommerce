# Alternative Solutions for Historical Pricing Problem

## 📊 Overview

This document explores different architectural solutions for maintaining historical price accuracy in e-commerce systems, comparing them to the **denormalization pattern** currently used in Bookty.

---

## 🎯 The Problem We're Solving

**Challenge**: How to preserve what customers actually paid when prices change over time?

**Current Solution**: Denormalization (copy prices into orders)

**Question**: Are there other ways to solve this?

**Answer**: Yes! Here are 5 alternative approaches:

---

## 🔄 Solution Comparison Matrix

| Solution | Complexity | Performance | Storage | Queries | Best For |
|----------|-----------|-------------|---------|---------|----------|
| **1. Denormalization** ✓ Current | ⭐ Simple | ⭐⭐⭐ Fast | 😐 Redundant | ⭐⭐⭐ Easy | Small-medium systems |
| **2. Price History Table** | ⭐⭐ Medium | ⭐⭐ Good | ⭐⭐⭐ Efficient | ⭐⭐ Medium | Price tracking needed |
| **3. Temporal Tables** | ⭐⭐⭐ Complex | ⭐⭐ Good | ⭐⭐ Good | ⭐ Complex | Database supports it |
| **4. Event Sourcing** | ⭐⭐⭐⭐ Very Complex | ⭐ Slower | 😐 Large | ⭐ Complex | Large enterprise |
| **5. Snapshot Pattern** | ⭐⭐ Medium | ⭐⭐⭐ Fast | 😐 Redundant | ⭐⭐ Medium | Document-based systems |

---

## 🎯 Solution 1: Denormalization Pattern (Current)

### How It Works

Copy price values directly into the order at checkout.

### Database Schema

```sql
-- Reference Table (changes over time)
CREATE TABLE postage_rates (
    id BIGINT PRIMARY KEY,
    region VARCHAR(50),
    customer_price DECIMAL(10,2),
    actual_cost DECIMAL(10,2),
    updated_at TIMESTAMP
);

-- Order Table (snapshot)
CREATE TABLE orders (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    -- NO FK to postage_rates!
    shipping_region VARCHAR(50),
    shipping_customer_price DECIMAL(10,2), -- Copied value
    shipping_actual_cost DECIMAL(10,2),     -- Copied value
    created_at TIMESTAMP
);
```

### Code Example

```php
// At checkout
$rate = PostageRate::where('region', 'sm')->first();

Order::create([
    'shipping_customer_price' => $rate->customer_price, // Copy
    'shipping_actual_cost' => $rate->actual_cost,       // Copy
]);
```

### Pros ✅
- **Very Simple**: Easy to implement and understand
- **Fast Queries**: No JOINs needed, direct access
- **No Dependencies**: Orders independent of rate changes
- **Easy Migration**: Simple to add to existing system

### Cons ❌
- **Data Redundancy**: Same price stored in multiple orders
- **No Audit Trail**: Can't see price history
- **Manual Sync**: Must remember to copy all fields
- **Storage Cost**: More disk space used

### When to Use
- ✅ Small to medium e-commerce sites
- ✅ Simple pricing structures
- ✅ When query performance is critical
- ✅ When simplicity is priority

---

## 🎯 Solution 2: Price History Table

### How It Works

Maintain a separate table that tracks all price changes with timestamps.

### Database Schema

```sql
-- Reference Table (current prices only)
CREATE TABLE postage_rates (
    id BIGINT PRIMARY KEY,
    region VARCHAR(50),
    customer_price DECIMAL(10,2),
    actual_cost DECIMAL(10,2)
);

-- History Table (all changes tracked)
CREATE TABLE postage_rate_history (
    id BIGINT PRIMARY KEY,
    postage_rate_id BIGINT,
    region VARCHAR(50),
    customer_price DECIMAL(10,2),
    actual_cost DECIMAL(10,2),
    valid_from TIMESTAMP,
    valid_until TIMESTAMP, -- NULL for current
    INDEX(postage_rate_id, valid_from, valid_until)
);

-- Order Table (reference to history)
CREATE TABLE orders (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    postage_rate_id BIGINT,
    postage_rate_history_id BIGINT, -- FK to history record
    shipping_region VARCHAR(50),
    created_at TIMESTAMP,
    FOREIGN KEY (postage_rate_history_id) 
        REFERENCES postage_rate_history(id)
);
```

### Code Example

```php
// Service to manage price history
class PostageRateService
{
    public function updateRate($region, $newCustomerPrice, $newActualCost)
    {
        $rate = PostageRate::where('region', $region)->first();
        
        // 1. Close current history record
        PostageRateHistory::where('postage_rate_id', $rate->id)
            ->whereNull('valid_until')
            ->update(['valid_until' => now()]);
        
        // 2. Create new history record
        $history = PostageRateHistory::create([
            'postage_rate_id' => $rate->id,
            'region' => $region,
            'customer_price' => $newCustomerPrice,
            'actual_cost' => $newActualCost,
            'valid_from' => now(),
            'valid_until' => null, // Current
        ]);
        
        // 3. Update current rate
        $rate->update([
            'customer_price' => $newCustomerPrice,
            'actual_cost' => $newActualCost,
        ]);
    }
    
    public function getRateAt($region, $date)
    {
        return PostageRateHistory::where('region', $region)
            ->where('valid_from', '<=', $date)
            ->where(function($q) use ($date) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>', $date);
            })
            ->first();
    }
}

// At checkout
$currentHistory = PostageRateHistory::where('region', 'sm')
    ->whereNull('valid_until')
    ->first();

Order::create([
    'postage_rate_history_id' => $currentHistory->id, // FK to history
    'shipping_region' => 'sm',
]);

// To get historical price
$order = Order::find(1001);
$historicalRate = $order->postageRateHistory;
echo $historicalRate->customer_price; // Original price
```

### Pros ✅
- **Full Audit Trail**: See all price changes over time
- **No Redundancy**: Prices stored once per change
- **Referential Integrity**: FK ensures history exists
- **Price Analysis**: Can analyze pricing trends
- **Regulatory Compliance**: Complete audit history

### Cons ❌
- **More Complex**: Need to maintain history table
- **Slower Queries**: Requires JOIN to get prices
- **Migration Effort**: More code to implement
- **History Management**: Need to handle edge cases

### When to Use
- ✅ Need detailed price change history
- ✅ Regulatory compliance requirements
- ✅ Want to analyze pricing strategies
- ✅ Multiple price changes expected
- ✅ Medium to large systems

---

## 🎯 Solution 3: Temporal Tables (Database-Level Versioning)

### How It Works

Use database built-in temporal/versioning features (SQL Server, PostgreSQL, MariaDB).

### Database Schema (PostgreSQL Example)

```sql
-- PostgreSQL with temporal tables
CREATE TABLE postage_rates (
    id BIGINT PRIMARY KEY,
    region VARCHAR(50),
    customer_price DECIMAL(10,2),
    actual_cost DECIMAL(10,2),
    valid_from TIMESTAMPTZ GENERATED ALWAYS AS ROW START,
    valid_until TIMESTAMPTZ GENERATED ALWAYS AS ROW END,
    PERIOD FOR SYSTEM_TIME (valid_from, valid_until)
) WITH (SYSTEM_VERSIONING = ON);

-- History table automatically created by database
-- postage_rates_history (managed by DB)

-- Orders just store FK
CREATE TABLE orders (
    id BIGINT PRIMARY KEY,
    postage_rate_id BIGINT,
    created_at TIMESTAMP,
    FOREIGN KEY (postage_rate_id) REFERENCES postage_rates(id)
);
```

### Code Example

```php
// Update rate (database handles versioning)
PostageRate::where('region', 'sm')
    ->update(['customer_price' => 6.00]);
// Database automatically saves old version to history

// Query historical rate
DB::statement("
    SELECT pr.customer_price, pr.actual_cost
    FROM postage_rates FOR SYSTEM_TIME AS OF :orderDate pr
    WHERE pr.id = :rateId
", [
    'orderDate' => $order->created_at,
    'rateId' => $order->postage_rate_id
]);

// Or use Laravel package
$historicalRate = PostageRate::asOf($order->created_at)
    ->find($order->postage_rate_id);
```

### Pros ✅
- **Automatic Versioning**: Database handles history
- **Clean Schema**: No manual history tables
- **Point-in-Time Queries**: Easy temporal queries
- **Standard SQL**: Using SQL standard features

### Cons ❌
- **Database Dependent**: Not all DBs support it
- **Learning Curve**: New SQL syntax to learn
- **Migration Complex**: Hard to add to existing DB
- **Limited Control**: Less control over history
- **Laravel Support**: Limited ORM support

### When to Use
- ✅ Database supports temporal tables
- ✅ Want automatic versioning
- ✅ Enterprise applications
- ✅ Strong compliance needs
- ❌ NOT for MySQL (limited support)

---

## 🎯 Solution 4: Event Sourcing

### How It Works

Store all events (changes) and reconstruct state by replaying events.

### Database Schema

```sql
-- Event Store (immutable log)
CREATE TABLE events (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    aggregate_id VARCHAR(255), -- e.g., 'postage_rate_sm'
    event_type VARCHAR(100),
    event_data JSON,
    created_at TIMESTAMP,
    INDEX(aggregate_id, created_at)
);

-- Projection/Read Model (optional, for performance)
CREATE TABLE postage_rates_projection (
    id BIGINT PRIMARY KEY,
    region VARCHAR(50),
    customer_price DECIMAL(10,2),
    actual_cost DECIMAL(10,2),
    version INT,
    updated_at TIMESTAMP
);

-- Orders store event reference
CREATE TABLE orders (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    postage_rate_event_id BIGINT, -- FK to specific event
    created_at TIMESTAMP,
    FOREIGN KEY (postage_rate_event_id) REFERENCES events(id)
);
```

### Code Example

```php
// Event classes
class PostageRateUpdated
{
    public function __construct(
        public string $region,
        public float $customerPrice,
        public float $actualCost,
        public Carbon $occurredAt
    ) {}
}

// Event Store
class EventStore
{
    public function append(string $aggregateId, $event)
    {
        DB::table('events')->insert([
            'aggregate_id' => $aggregateId,
            'event_type' => get_class($event),
            'event_data' => json_encode($event),
            'created_at' => now(),
        ]);
    }
    
    public function getEvents(string $aggregateId)
    {
        return DB::table('events')
            ->where('aggregate_id', $aggregateId)
            ->orderBy('created_at')
            ->get();
    }
}

// Update rate (append event)
$event = new PostageRateUpdated(
    region: 'sm',
    customerPrice: 6.00,
    actualCost: 4.00,
    occurredAt: now()
);

$eventStore = new EventStore();
$eventId = $eventStore->append('postage_rate_sm', $event);

// At checkout
Order::create([
    'postage_rate_event_id' => $eventId, // Reference to event
]);

// Reconstruct state at specific time
class PostageRateProjection
{
    public function asOf(string $region, Carbon $date)
    {
        $events = DB::table('events')
            ->where('aggregate_id', "postage_rate_{$region}")
            ->where('created_at', '<=', $date)
            ->orderBy('created_at')
            ->get();
        
        // Replay events
        $state = ['customer_price' => 0, 'actual_cost' => 0];
        foreach ($events as $event) {
            $data = json_decode($event->event_data);
            $state['customer_price'] = $data->customerPrice;
            $state['actual_cost'] = $data->actualCost;
        }
        
        return $state;
    }
}
```

### Pros ✅
- **Complete Audit Trail**: Every change is an event
- **Time Travel**: Reconstruct state at any point
- **Event Replay**: Can rebuild system from events
- **Debugging**: See exactly what happened when
- **CQRS**: Separate read/write models
- **Scalability**: Can distribute event processing

### Cons ❌
- **Very Complex**: Steep learning curve
- **Event Versioning**: Hard to change event schema
- **Query Performance**: Need projections for speed
- **Storage Growth**: Events accumulate forever
- **Eventual Consistency**: Read models lag behind
- **Overkill**: Too complex for simple apps

### When to Use
- ✅ Large enterprise applications
- ✅ Complex business domains
- ✅ Need complete audit trail
- ✅ Microservices architecture
- ✅ High scalability requirements
- ❌ NOT for simple e-commerce

---

## 🎯 Solution 5: Snapshot/Document Pattern

### How It Works

Store complete snapshot of related data as JSON document in order.

### Database Schema

```sql
-- Orders with embedded snapshots
CREATE TABLE orders (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    
    -- JSON snapshot of all pricing data
    pricing_snapshot JSON,
    
    created_at TIMESTAMP
);

-- Example pricing_snapshot:
-- {
--   "shipping": {
--     "region": "sm",
--     "customer_price": 5.00,
--     "actual_cost": 3.50
--   },
--   "items": [
--     {
--       "book_id": 123,
--       "title": "Book Title",
--       "price": 45.00,
--       "cost_price": 25.00,
--       "quantity": 1
--     }
--   ],
--   "coupon": {
--     "code": "SAVE10",
--     "discount": 4.50
--   }
-- }
```

### Code Example

```php
// Create order with complete snapshot
$rate = PostageRate::where('region', 'sm')->first();

$pricingSnapshot = [
    'shipping' => [
        'region' => $rate->region,
        'customer_price' => $rate->customer_price,
        'actual_cost' => $rate->actual_cost,
    ],
    'items' => $cart->items->map(fn($item) => [
        'book_id' => $item->book_id,
        'title' => $item->book->title,
        'author' => $item->book->author,
        'price' => $item->book->price,
        'cost_price' => $item->book->cost_price,
        'quantity' => $item->quantity,
        'subtotal' => $item->book->price * $item->quantity,
    ]),
    'coupon' => $coupon ? [
        'code' => $coupon->code,
        'type' => $coupon->discount_type,
        'value' => $coupon->discount_value,
        'discount' => $discountAmount,
    ] : null,
    'timestamp' => now()->toIso8601String(),
];

Order::create([
    'user_id' => $user->id,
    'pricing_snapshot' => $pricingSnapshot, // Complete snapshot
]);

// Access snapshot data
$order = Order::find(1001);
$snapshot = $order->pricing_snapshot;

echo $snapshot['shipping']['customer_price']; // 5.00
echo $snapshot['items'][0]['price']; // 45.00
```

### Pros ✅
- **Complete Context**: All related data in one place
- **Flexible Schema**: Can store any data structure
- **Easy Retrieval**: No JOINs, one query
- **Document-Friendly**: Works great with MongoDB
- **Future-Proof**: Can add fields without migration

### Cons ❌
- **Large Documents**: Can get very large
- **Query Limitations**: Can't easily query JSON fields (depends on DB)
- **Data Redundancy**: Lots of duplicate data
- **Type Safety**: Lose strong typing
- **Validation**: Need to validate JSON structure

### When to Use
- ✅ Using MongoDB or document DB
- ✅ Need complete order context
- ✅ Schema changes frequently
- ✅ Want flexibility over normalization
- ❌ NOT if you need to query historical prices

---

## 📊 Detailed Comparison

### Performance Comparison

| Operation | Denormalization | History Table | Temporal | Event Sourcing | Snapshot |
|-----------|----------------|---------------|----------|----------------|----------|
| **Insert Order** | Fast ⚡ | Fast ⚡ | Fast ⚡ | Medium 🐌 | Fast ⚡ |
| **Get Order Price** | Very Fast ⚡⚡⚡ | Medium 🐌 | Medium 🐌 | Slow 🐢 | Very Fast ⚡⚡⚡ |
| **Update Price** | Fast ⚡ | Medium 🐌 | Fast ⚡ | Fast ⚡ | Fast ⚡ |
| **Price History** | ❌ N/A | Fast ⚡ | Fast ⚡ | Medium 🐌 | ❌ N/A |
| **Storage Overhead** | Medium | Low | Low | High | High |

### Implementation Complexity

```
Simple          Medium          Complex         Very Complex
  |               |               |                 |
  v               v               v                 v
[Denormalization] [History Table] [Temporal]   [Event Sourcing]
                  [Snapshot]
```

### Migration Effort (Adding to Existing System)

1. **Denormalization**: ⭐ Very Easy
   - Add columns to orders table
   - Update checkout code
   
2. **Snapshot Pattern**: ⭐ Very Easy
   - Add JSON column
   - Update checkout code

3. **History Table**: ⭐⭐ Medium
   - Create history table
   - Add triggers or service layer
   - Migrate existing data

4. **Temporal Tables**: ⭐⭐⭐ Hard
   - Database-specific setup
   - May need DB migration
   - Limited Laravel support

5. **Event Sourcing**: ⭐⭐⭐⭐ Very Hard
   - Complete architecture change
   - Event store infrastructure
   - CQRS projections
   - Team training needed

---

## 🎯 Recommendation for Bookty

### Current Situation
- Laravel-based e-commerce
- MySQL database
- Small to medium scale
- Simple pricing structure

### Recommended Solution: **Keep Denormalization** ✅

**Why?**
1. ✅ **Proven Pattern**: Works well for e-commerce
2. ✅ **Simple**: Easy to maintain
3. ✅ **Fast**: No JOIN overhead
4. ✅ **Laravel-Friendly**: Easy to implement
5. ✅ **Sufficient**: Meets all requirements

### Consider Upgrading To: **History Table** (If Needed)

**When to upgrade:**
- Need detailed price change audit
- Regulatory compliance requirements
- Want to analyze pricing trends
- Planning to add dynamic pricing

**Migration Path:**
```php
// Phase 1: Add history tracking (parallel to current)
Schema::create('postage_rate_history', function (Blueprint $table) {
    $table->id();
    $table->foreignId('postage_rate_id');
    $table->string('region');
    $table->decimal('customer_price', 10, 2);
    $table->decimal('actual_cost', 10, 2);
    $table->timestamp('valid_from');
    $table->timestamp('valid_until')->nullable();
    $table->index(['postage_rate_id', 'valid_from', 'valid_until']);
});

// Phase 2: Keep denormalization but also link to history
Schema::table('orders', function (Blueprint $table) {
    $table->foreignId('postage_rate_history_id')
          ->nullable()
          ->after('shipping_actual_cost');
});

// Phase 3: Gradually migrate to history-based system
```

### Don't Use (For Bookty):
- ❌ **Temporal Tables**: MySQL has limited support
- ❌ **Event Sourcing**: Too complex for current needs
- ❌ **Snapshot Pattern**: Denormalization is cleaner

---

## 💡 Hybrid Approach (Best of Both Worlds)

You can combine denormalization with history tracking:

```php
class Order extends Model
{
    // Denormalized fields (fast access)
    protected $fillable = [
        'shipping_customer_price',
        'shipping_actual_cost',
        'postage_rate_history_id', // Optional FK to history
    ];
    
    // Relationship to history (for audit)
    public function postageRateHistory()
    {
        return $this->belongsTo(PostageRateHistory::class);
    }
}

// At checkout
$historyRecord = $this->postageRateService->getCurrentHistory('sm');

Order::create([
    // Denormalized (for performance)
    'shipping_customer_price' => $historyRecord->customer_price,
    'shipping_actual_cost' => $historyRecord->actual_cost,
    
    // History reference (for audit)
    'postage_rate_history_id' => $historyRecord->id,
]);
```

**Benefits:**
- ✅ Fast queries (uses denormalized fields)
- ✅ Audit trail (can follow history FK)
- ✅ Flexibility (can use either approach)

---

## 📝 Summary

| If You Need... | Use This Solution |
|----------------|-------------------|
| Simple, fast e-commerce | **Denormalization** ✓ Current |
| Price change audit trail | **History Table** |
| Database-managed versioning | **Temporal Tables** |
| Complete event audit | **Event Sourcing** |
| Flexible document storage | **Snapshot Pattern** |
| Best performance + audit | **Hybrid: Denormalization + History** |

### Final Verdict for Bookty:

**Current approach (Denormalization) is CORRECT ✅**

- Appropriate for your scale
- Standard e-commerce pattern  
- Easy to maintain
- Meets all requirements
- Consider adding history tracking in future if needed

---

## 📚 Further Reading

- [Temporal Data Management](https://en.wikipedia.org/wiki/Temporal_database)
- [Event Sourcing Pattern](https://martinfowler.com/eaaDev/EventSourcing.html)
- [Snapshot Pattern](https://www.enterpriseintegrationpatterns.com/patterns/messaging/SnapshotSeparation.html)
- [Database Normalization vs Denormalization](https://www.sqlshack.com/denormalization-in-database/)

---

**Conclusion**: Your current denormalization approach is the right choice! Other solutions exist but add complexity that isn't needed for your use case. 🎉
