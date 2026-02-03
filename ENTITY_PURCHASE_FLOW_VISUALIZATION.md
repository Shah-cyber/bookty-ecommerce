# Entity Purchase Flow Visualization - Bookty E-Commerce

**Complete entity-to-entity journey from browsing to order completion**

---

## 📋 Table of Contents

1. [Overview](#overview)
2. [Complete Entity Flow Diagram](#complete-entity-flow-diagram)
3. [Stage 1: Pre-Purchase (Browsing)](#stage-1-pre-purchase-browsing)
4. [Stage 2: Adding to Cart](#stage-2-adding-to-cart)
5. [Stage 3: Checkout Process](#stage-3-checkout-process)
6. [Stage 4: Order Creation](#stage-4-order-creation)
7. [Stage 5: Payment Processing](#stage-5-payment-processing)
8. [Stage 6: Post-Purchase](#stage-6-post-purchase)
9. [Entity State Transitions](#entity-state-transitions)
10. [Data Flow Summary](#data-flow-summary)

---

## Overview

This document visualizes how entities interact during the complete purchase journey in the Bookty system, from a user browsing books to a completed order.

### Key Principles

- **No Direct Cart → Order Relationship**: Cart and Order never reference each other
- **Data Copying**: CartItem data is copied (not referenced) to OrderItem
- **Cart Reusability**: Same cart is cleared and reused for future purchases
- **Atomic Transactions**: Order creation happens in a single database transaction
- **Snapshot Pattern**: Prices are captured at purchase time in OrderItem

---

## Complete Entity Flow Diagram

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                          BOOKTY PURCHASE FLOW                                   │
│                     Entity-to-Entity Relationship Journey                        │
└─────────────────────────────────────────────────────────────────────────────────┘

STAGE 1: BROWSING & DISCOVERY
═══════════════════════════════════════════════════════════════════════════════════

    ┌──────────┐
    │   User   │ (not logged in yet)
    └──────────┘
         │
         │ browses
         ↓
    ┌──────────┐      ┌──────────┐      ┌──────────┐
    │  Books   │◄─────│  Genres  │      │  Tropes  │
    └──────────┘      └──────────┘      └──────────┘
         │                  │                  │
         │                  └─────┬────────────┘
         │                        │
         └────────────────┬───────┘
                          │
                    ┌─────▼─────┐
                    │ Book_Genre│ (pivot)
                    │Book_Trope │ (pivot)
                    └───────────┘


STAGE 2: ADDING TO CART (User must login)
═══════════════════════════════════════════════════════════════════════════════════

    ┌──────────┐
    │   User   │ ◄─── Authenticated
    └────┬─────┘
         │
         │ owns (1:1)
         ↓
    ┌──────────┐
    │   Cart   │ (created automatically on first add)
    └────┬─────┘
         │
         │ contains (1:N)
         ↓
    ┌──────────────┐
    │  Cart_Items  │ ◄────┐
    └────┬─────────┘      │
         │                │ references (N:1)
         │ references     │
         │ (N:1)          │
         ↓                │
    ┌──────────┐          │
    │  Books   │──────────┘
    └────┬─────┘
         │
         │ may have active
         ↓
    ┌──────────────┐      ┌──────────────┐
    │ Flash_Sales  │      │Book_Discounts│
    └──────────────┘      └──────────────┘
         (applies during price calculation)

    ALSO TRIGGERED:
    ┌────────────────────────┐
    │ User_Book_Interactions │ ← Records "add_to_cart" event
    └────────────────────────┘
         (for recommendation system)


STAGE 3: CHECKOUT INITIATION
═══════════════════════════════════════════════════════════════════════════════════

    ┌──────────┐
    │   User   │
    └────┬─────┘
         │
         │ proceeds to checkout
         │
    ┌────▼─────┐
    │   Cart   │ ← Validated (has items, in stock)
    └────┬─────┘
         │
         │ loads
         ↓
    ┌──────────────┐      ┌──────────┐
    │  Cart_Items  │─────►│  Books   │ ← Stock checked
    └──────────────┘      └────┬─────┘
                               │
                               │ has pricing from
                               ↓
                          ┌──────────────┐
                          │ Flash_Sales  │
                          │Book_Discounts│
                          └──────────────┘

    User may apply:
    ┌──────────┐
    │ Coupons  │ ← Validated (active, not expired, min purchase met)
    └──────────┘
         │
         └─► May provide: discount_amount AND/OR free_shipping

    User selects shipping:
    ┌──────────────┐
    │Postage_Rates │ ← Based on shipping_state
    └──────────────┘
         │
         └─► Provides: customer_price, actual_cost


STAGE 4: ORDER CREATION (ATOMIC TRANSACTION)
═══════════════════════════════════════════════════════════════════════════════════

┌───────────────────────────────── DB TRANSACTION BEGINS ─────────────────────────┐
│                                                                                  │
│   ┌──────────┐                                                                  │
│   │   User   │                                                                  │
│   └────┬─────┘                                                                  │
│        │                                                                         │
│        │ places                                                                  │
│        ↓                                                                         │
│   ┌──────────┐ ◄──── NEW RECORD CREATED                                        │
│   │  Orders  │                                                                  │
│   └────┬─────┘                                                                  │
│        │                                                                         │
│        │ Properties:                                                             │
│        │ • user_id (FK to User)                                                 │
│        │ • public_id (unique tracking)                                          │
│        │ • toyyibpay_bill_code (unique bill)                                    │
│        │ • postage_rate_history_id (FK to Postage_Rate_History) ◄─┐            │
│        │ • shipping_customer_price (snapshot)                      │            │
│        │ • shipping_actual_cost (snapshot)                         │            │
│        │ • discount_amount (if coupon applied)                     │            │
│        │ • coupon_code (if coupon applied)                         │            │
│        │ • is_free_shipping (from coupon or free promo)            │            │
│        │ • shipping_address, shipping_city, etc.                   │            │
│        │ • total_amount                                             │            │
│        │ • status = 'pending'                                       │            │
│        │ • payment_status = 'pending'                               │            │
│        │                                                             │            │
│        │                                                             │            │
│        │ contains (1:N)                                              │            │
│        ↓                                                             │            │
│   ┌───────────────┐ ◄──── NEW RECORDS CREATED (copied from Cart)   │            │
│   │  Order_Items  │                                                 │            │
│   └───┬───────────┘                                                 │            │
│       │                                                              │            │
│       │ Properties (SNAPSHOT):                                      │            │
│       │ • order_id (FK to Order)                                    │            │
│       │ • book_id (FK to Book)                                      │            │
│       │ • quantity (copied from Cart_Item)                          │            │
│       │ • price (snapshot from Book at purchase time) ◄────────┐   │            │
│       │ • cost_price (snapshot from Book at purchase time)     │   │            │
│       │                                                         │   │            │
│       │ references                                              │   │            │
│       ↓                                                         │   │            │
│   ┌──────────┐                                                  │   │            │
│   │  Books   │ ◄────────────────────────────────────────────────┘   │            │
│   └────┬─────┘                                                      │            │
│        │                                                             │            │
│        │ UPDATED: stock_quantity -= ordered_quantity                │            │
│        │          (locked with lockForUpdate())                     │            │
│        │                                                             │            │
│        └─► Stock validation happens HERE (prevent overselling)      │            │
│                                                                      │            │
│   PARALLEL: Create postage rate snapshot                            │            │
│   ┌──────────────┐           ┌────────────────────────┐            │            │
│   │Postage_Rates │──copy────►│Postage_Rate_History    │────────────┘            │
│   └──────────────┘           └────────────────────────┘                         │
│   (current rate)             (snapshot at purchase time)                        │
│                              • region                                            │
│                              • state                                             │
│                              • customer_price                                    │
│                              • actual_cost                                       │
│                              • valid_from                                        │
│                                                                                  │
│   IF COUPON USED:                                                                │
│   ┌──────────┐                                                                  │
│   │ Coupons  │ ◄─── order.coupon_code references (not FK!)                     │
│   └────┬─────┘                                                                  │
│        │                                                                         │
│        └─► UPDATED: usage_count += 1                                            │
│                                                                                  │
│   CART CLEANUP:                                                                 │
│   ┌──────────────┐                                                              │
│   │  Cart_Items  │ ◄─── DELETE all items WHERE cart_id = user's cart           │
│   └──────────────┘                                                              │
│   (Cart record remains, but empty - reusable for next purchase)                │
│                                                                                  │
└──────────────────────────────── DB TRANSACTION ENDS ────────────────────────────┘
                                    (COMMIT)


STAGE 5: PAYMENT PROCESSING
═══════════════════════════════════════════════════════════════════════════════════

    ┌──────────┐
    │  Orders  │ status = 'pending'
    └────┬─────┘
         │
         │ integrated with
         ↓
    ┌────────────────┐
    │   ToyyibPay    │ (External Payment Gateway)
    │   API Service  │
    └────┬───────────┘
         │
         │ creates bill
         │
         ├─► Bill Code stored: orders.toyyibpay_bill_code
         │
         ├─► Payment URL stored: orders.toyyibpay_payment_url
         │
         └─► User redirected to ToyyibPay payment page

    
    ┌────────────────────────────────────────────────────────────┐
    │           PAYMENT CALLBACK (Server-to-Server)              │
    └────────────────────────────────────────────────────────────┘
    
    ToyyibPay sends callback:
         │
         ↓
    ┌──────────┐
    │  Orders  │ ◄─── UPDATED based on payment status
    └──────────┘
         │
         ├─► IF payment_status = 1 (success):
         │   • orders.status = 'processing'
         │   • orders.payment_status = 'paid'
         │   • orders.payment_date = now()
         │
         ├─► IF payment_status = 2 (pending):
         │   • orders.status = 'pending'
         │   • orders.payment_status = 'pending'
         │
         └─► IF payment_status = 3 (failed):
             • orders.status = 'failed'
             • orders.payment_status = 'failed'


STAGE 6: POST-PURCHASE (Order Management)
═══════════════════════════════════════════════════════════════════════════════════

    ┌──────────┐
    │   User   │
    └────┬─────┘
         │
         │ can view
         ↓
    ┌──────────┐ status can be: pending → processing → shipped → completed
    │  Orders  │ or: failed, cancelled
    └────┬─────┘
         │
         │ contains
         ↓
    ┌───────────────┐      ┌──────────┐
    │  Order_Items  │─────►│  Books   │ (referenced, not modified)
    └───────────────┘      └──────────┘
         │                      
         │ stored snapshot prices
         │ (preserve historical values even if book price changes)
         │
         └─► price, cost_price (frozen at purchase time)

    Admin can manage via:
    ┌──────────┐      ┌───────────────┐
    │  Roles   │─────►│  Permissions  │
    └──────────┘      └───────────────┘
         │                    │
         └────────┬───────────┘
                  │
            ┌─────▼─────┐
            │Admin Users│ ← Can update order status
            └───────────┘

    For analytics/recommendations:
    ┌────────────────────────┐
    │ User_Book_Interactions │ ← Records "purchase" event
    └────────────────────────┘
         │
         └─► Triggers recommendation updates

    Financial tracking:
    ┌────────────────────────┐
    │Postage_Rate_History    │ ← Historical postage cost
    └────────────────────────┘
         │
         └─► For profit/cost analysis

```

---

## Stage 1: Pre-Purchase (Browsing)

### Entity Relationships

```
┌─────────────────────────────────────────────┐
│  DISCOVERY PHASE - NO CART YET              │
└─────────────────────────────────────────────┘

    Guest/User
         │
         │ browses by
         ↓
    ┌──────────┐
    │  Genres  │ ────┐
    └──────────┘     │
                     │ many-to-many
    ┌──────────┐     │ (through pivots)
    │  Tropes  │ ────┤
    └──────────┘     │
                     ↓
                ┌──────────┐
                │  Books   │
                └────┬─────┘
                     │
                     │ has (1:N)
                     ↓
                ┌──────────────┐
                │  Reviews     │
                └──────────────┘

                ┌──────────────┐
                │ Bookshelves  │ (many-to-many)
                └──────────────┘
```

### Data Flow

1. **User visits homepage**
   - System loads: `Books`, `Genres`, `Tropes`
   - Relationships loaded via: `Book_Genre`, `Book_Trope` pivot tables

2. **User filters books**
   - By Genre: `Books::whereHas('genres', function($q) { $q->where('genre_id', $genreId); })`
   - By Trope: `Books::whereHas('tropes', function($q) { $q->where('trope_id', $tropeId); })`

3. **User views book details**
   - System loads: `Book` with `reviews`, `genres`, `tropes`, `bookshelves`
   - Check active: `Flash_Sales`, `Book_Discounts`
   - Display calculated price

**No cart entities involved yet!**

---

## Stage 2: Adding to Cart

### Entity Creation & Updates

```
┌──────────────────────────────────────────────────────────────┐
│  USER ADDS BOOK TO CART                                      │
└──────────────────────────────────────────────────────────────┘

STEP 1: User Authentication Check
    IF (Auth::guest()) → Redirect to login
    ELSE → Proceed

STEP 2: Cart Creation/Retrieval
    ┌──────────┐
    │   User   │ id = 5
    └────┬─────┘
         │
         │ Cart::firstOrCreate(['user_id' => 5])
         ↓
    ┌──────────┐
    │   Cart   │ id = 10, user_id = 5  ◄─── Created if doesn't exist
    └──────────┘

STEP 3: Book Validation
    ┌──────────┐
    │  Books   │ id = 42
    └────┬─────┘
         │
         ├─► Check: is_available = true
         ├─► Check: stock_quantity >= requested_quantity
         └─► Get: price (with active discounts)

STEP 4: Cart Item Creation/Update
    ┌──────────────┐
    │  Cart_Items  │
    └──────────────┘
         │
         ├─► IF exists (cart_id=10, book_id=42):
         │       UPDATE quantity = quantity + requested_quantity
         │       UPDATE updated_at = now()
         │
         └─► ELSE:
                 INSERT (cart_id=10, book_id=42, quantity=2, created_at, updated_at)

STEP 5: Interaction Tracking
    ┌────────────────────────┐
    │ User_Book_Interactions │
    └────────────────────────┘
         │
         └─► INSERT (user_id=5, book_id=42, action='add_to_cart', weight=2)
             (for recommendation system)

STEP 6: Response
    → Return Cart with items count
    → Frontend updates cart badge
```

### SQL Flow

```sql
-- Step 1: Get or create cart
SELECT * FROM carts WHERE user_id = 5;
-- If not exists:
INSERT INTO carts (user_id, created_at, updated_at) VALUES (5, NOW(), NOW());

-- Step 2: Check book availability
SELECT id, title, price, stock_quantity, is_available 
FROM books 
WHERE id = 42 AND is_available = 1;

-- Step 3: Check for existing cart item
SELECT * FROM cart_items WHERE cart_id = 10 AND book_id = 42;

-- Step 4a: If exists - Update quantity
UPDATE cart_items 
SET quantity = quantity + 2, updated_at = NOW()
WHERE cart_id = 10 AND book_id = 42;

-- Step 4b: If not exists - Create new
INSERT INTO cart_items (cart_id, book_id, quantity, created_at, updated_at)
VALUES (10, 42, 2, NOW(), NOW());

-- Step 5: Record interaction
INSERT INTO user_book_interactions 
(user_id, book_id, action, weight, last_interacted_at, created_at, updated_at)
VALUES (5, 42, 'add_to_cart', 2, NOW(), NOW(), NOW());

-- Step 6: Get updated cart
SELECT ci.*, b.title, b.price, b.slug
FROM cart_items ci
JOIN books b ON ci.book_id = b.id
WHERE ci.cart_id = 10;
```

---

## Stage 3: Checkout Process

### Entity Interactions During Checkout

```
┌──────────────────────────────────────────────────────────────┐
│  CHECKOUT PAGE LOAD                                          │
└──────────────────────────────────────────────────────────────┘

STEP 1: Load User's Cart
    ┌──────────┐
    │   User   │ id = 5, authenticated
    └────┬─────┘
         │
         │ has one
         ↓
    ┌──────────┐
    │   Cart   │ id = 10
    └────┬─────┘
         │
         │ ->load('items.book')
         ↓
    ┌──────────────┐      ┌──────────┐
    │  Cart_Items  │─────►│  Books   │
    └──────────────┘      └────┬─────┘
         │                     │
         │                     │ calculate final price
         │                     │ (with flash sales, discounts)
         │                     ↓
         │                ┌──────────────┐    ┌──────────────┐
         │                │ Flash_Sales  │    │Book_Discounts│
         │                └──────────────┘    └──────────────┘
         │
         └─► Calculate: subtotal = Σ(item.quantity × book.final_price)

STEP 2: Load Shipping Options
    ┌──────────────┐
    │Postage_Rates │ WHERE is_active = 1
    └──────────────┘
         │
         └─► Display: customer_price per state

STEP 3: Auto-fill User Profile
    ┌──────────┐
    │   User   │
    └──────────┘
         │
         └─► Load: name, email, phone_number, address, postal_code, city, state

STEP 4: Available Coupons (optional display)
    ┌──────────┐
    │ Coupons  │ WHERE is_active = 1 AND now() BETWEEN starts_at AND expires_at
    └──────────┘
         │
         └─► Filter: min_purchase_amount <= subtotal
```

### Coupon Application Flow

```
┌──────────────────────────────────────────────────────────────┐
│  USER APPLIES COUPON                                         │
└──────────────────────────────────────────────────────────────┘

    Frontend → AJAX POST /api/coupons/validate
         │
         │ payload: { code: 'SAVE10', amount: 150.00 }
         ↓
    
    Backend: CouponController@validate
         │
         ├─► Query: Coupons WHERE code = 'SAVE10'
         │
         ├─► Validate:
         │   • is_active = true
         │   • usage_count < max_uses (if set)
         │   • now() >= starts_at
         │   • now() <= expires_at
         │   • amount >= min_purchase_amount (if set)
         │   • max_uses_per_user check (if set)
         │
         ├─► Calculate discount:
         │   IF discount_type = 'fixed':
         │       discount_amount = min(discount_value, amount)
         │   ELSE IF discount_type = 'percentage':
         │       discount_amount = (amount × discount_value) / 100
         │   ELSE IF free_shipping = true AND no discount_value:
         │       discount_amount = 0
         │
         └─► Return JSON:
                 {
                   valid: true,
                   discount_amount: 15.00,
                   free_shipping: false,
                   message: "Coupon applied successfully!"
                 }

    Frontend receives response:
         │
         ├─► Update subtotal display
         ├─► Show discount row (if discount_amount > 0)
         ├─► Update shipping (if free_shipping = true)
         └─► Recalculate total
```

---

## Stage 4: Order Creation

### Atomic Transaction - Complete Entity Flow

```
┌══════════════════════════════════════════════════════════════════════════════┐
║                      DB::beginTransaction()                                  ║
║                      ═══════════════════════                                 ║
║  All operations MUST succeed, or ALL will be rolled back                     ║
└══════════════════════════════════════════════════════════════════════════════┘

┌─────────────────────────────────────────────────────────────┐
│ STEP 1: VALIDATE CART & STOCK (with row locking)           │
└─────────────────────────────────────────────────────────────┘

    ┌──────────────┐
    │  Cart_Items  │ WHERE cart_id = 10
    └───────┬──────┘
            │
            │ JOIN
            ↓
    ┌──────────┐ ◄─── lockForUpdate() (row-level lock)
    │  Books   │
    └──────────┘
            │
            ├─► CHECK: stock_quantity >= cart_item.quantity
            │   IF insufficient → ROLLBACK + error
            │
            └─► Calculate total_amount


┌─────────────────────────────────────────────────────────────┐
│ STEP 2: CREATE POSTAGE RATE SNAPSHOT                       │
└─────────────────────────────────────────────────────────────┘

    ┌──────────────┐
    │Postage_Rates │ WHERE state = $shipping_state AND is_active = 1
    └───────┬──────┘
            │
            │ COPY TO
            ↓
    ┌────────────────────────┐ ◄─── NEW RECORD
    │Postage_Rate_History    │
    └────────────────────────┘
            │
            ├─► region = 'West Malaysia'
            ├─► state = 'Selangor'
            ├─► customer_price = 10.00
            ├─► actual_cost = 7.00
            ├─► valid_from = '2025-01-01'
            └─► Returns: postage_rate_history_id = 99


┌─────────────────────────────────────────────────────────────┐
│ STEP 3: CREATE ORDER RECORD                                │
└─────────────────────────────────────────────────────────────┘

    ┌──────────┐ ◄─── NEW RECORD CREATED
    │  Orders  │
    └──────────┘
            │
            ├─► user_id = 5 (FK)
            ├─► public_id = 'ORD-20250102-XYZ123' (unique)
            ├─► toyyibpay_bill_code = NULL (to be set later)
            ├─► postage_rate_history_id = 99 (FK)
            ├─► shipping_customer_price = 10.00 (snapshot)
            ├─► shipping_actual_cost = 7.00 (snapshot)
            ├─► is_free_shipping = false
            ├─► discount_amount = 15.00 (if coupon applied)
            ├─► coupon_code = 'SAVE10' (if coupon applied)
            ├─► shipping_address = '123 Jalan Merdeka'
            ├─► shipping_city = 'Kuala Lumpur'
            ├─► shipping_state = 'Wilayah Persekutuan'
            ├─► shipping_postal_code = '50000'
            ├─► shipping_phone = '+60123456789'
            ├─► total_amount = 145.00 (subtotal - discount + shipping)
            ├─► status = 'pending'
            ├─► payment_status = 'pending'
            ├─► created_at = NOW()
            └─► Returns: order_id = 500


┌─────────────────────────────────────────────────────────────┐
│ STEP 4: CREATE ORDER ITEMS (from Cart Items)               │
└─────────────────────────────────────────────────────────────┘

    FOR EACH Cart_Item:
    
    ┌──────────────┐
    │  Cart_Items  │ (cart_id=10, book_id=42, quantity=2)
    └───────┬──────┘
            │
            │ JOIN to get current book data
            ↓
    ┌──────────┐
    │  Books   │ (id=42, price=75.00, cost_price=50.00)
    └──────────┘
            │
            │ COPY DATA TO
            ↓
    ┌───────────────┐ ◄─── NEW RECORD
    │  Order_Items  │
    └───────────────┘
            │
            ├─► order_id = 500 (FK to new order)
            ├─► book_id = 42 (FK to book)
            ├─► quantity = 2 (copied from cart_item)
            ├─► price = 75.00 (SNAPSHOT from book.price at purchase time)
            ├─► cost_price = 50.00 (SNAPSHOT from book.cost_price)
            ├─► created_at = NOW()
            └─► updated_at = NOW()

    REPEAT for all cart items...


┌─────────────────────────────────────────────────────────────┐
│ STEP 5: UPDATE BOOK STOCK                                  │
└─────────────────────────────────────────────────────────────┘

    FOR EACH Order_Item:
    
    ┌──────────┐
    │  Books   │ (id=42, current stock_quantity=100)
    └──────────┘
            │
            ├─► UPDATE stock_quantity = stock_quantity - order_item.quantity
            │   (100 - 2 = 98)
            │
            └─► RE-CHECK: stock_quantity >= 0
                IF negative → ROLLBACK + error


┌─────────────────────────────────────────────────────────────┐
│ STEP 6: UPDATE COUPON USAGE                                │
└─────────────────────────────────────────────────────────────┘

    IF coupon was applied:
    
    ┌──────────┐
    │ Coupons  │ (code='SAVE10')
    └──────────┘
            │
            └─► UPDATE usage_count = usage_count + 1


┌─────────────────────────────────────────────────────────────┐
│ STEP 7: RECORD PURCHASE INTERACTION                        │
└─────────────────────────────────────────────────────────────┘

    FOR EACH Order_Item:
    
    ┌────────────────────────┐ ◄─── NEW/UPDATE RECORD
    │ User_Book_Interactions │
    └────────────────────────┘
            │
            ├─► user_id = 5
            ├─► book_id = 42
            ├─► action = 'purchase'
            ├─► weight = 10 (purchase has highest weight)
            ├─► count = count + 1
            └─► last_interacted_at = NOW()


┌─────────────────────────────────────────────────────────────┐
│ STEP 8: CLEAR CART                                         │
└─────────────────────────────────────────────────────────────┘

    ┌──────────────┐
    │  Cart_Items  │ WHERE cart_id = 10
    └──────────────┘
            │
            └─► DELETE all records

    ┌──────────┐
    │   Cart   │ (id=10) ◄─── REMAINS (not deleted, reusable)
    └──────────┘


┌══════════════════════════════════════════════════════════════════════════════┐
║                      DB::commit()                                            ║
║                      ════════════                                            ║
║  All operations successful! Order created with ID: 500                       ║
└══════════════════════════════════════════════════════════════════════════════┘

    RESULT:
    ✅ Order record created
    ✅ Order items created with snapshot prices
    ✅ Book stock reduced
    ✅ Postage rate snapshot created
    ✅ Coupon usage updated (if used)
    ✅ User interactions recorded
    ✅ Cart cleared
```

### SQL Transaction

```sql
-- Start transaction
BEGIN;

-- STEP 1: Lock and validate books
SELECT id, title, price, cost_price, stock_quantity
FROM books
WHERE id IN (42, 55, 78)
FOR UPDATE; -- Row-level lock to prevent race conditions

-- Validate sufficient stock
-- (Application logic checks each book.stock_quantity >= cart_item.quantity)

-- STEP 2: Create postage rate snapshot
INSERT INTO postage_rate_history (region, state, customer_price, actual_cost, valid_from, created_at, updated_at)
SELECT region, state, customer_price, actual_cost, valid_from, NOW(), NOW()
FROM postage_rates
WHERE state = 'Selangor' AND is_active = 1
LIMIT 1;
-- Returns: postage_rate_history_id = 99

-- STEP 3: Create order
INSERT INTO orders (
    user_id, public_id, postage_rate_history_id,
    shipping_customer_price, shipping_actual_cost, is_free_shipping,
    discount_amount, coupon_code,
    shipping_address, shipping_city, shipping_state, shipping_postal_code, shipping_phone,
    total_amount, status, payment_status, created_at, updated_at
)
VALUES (
    5, 'ORD-20250102-XYZ123', 99,
    10.00, 7.00, 0,
    15.00, 'SAVE10',
    '123 Jalan Merdeka', 'Kuala Lumpur', 'Wilayah Persekutuan', '50000', '+60123456789',
    145.00, 'pending', 'pending', NOW(), NOW()
);
-- Returns: order_id = 500

-- STEP 4: Create order items (from cart items)
INSERT INTO order_items (order_id, book_id, quantity, price, cost_price, created_at, updated_at)
SELECT 500, ci.book_id, ci.quantity, b.price, b.cost_price, NOW(), NOW()
FROM cart_items ci
JOIN books b ON ci.book_id = b.id
WHERE ci.cart_id = 10;

-- STEP 5: Update book stock
UPDATE books b
JOIN cart_items ci ON b.id = ci.book_id
SET b.stock_quantity = b.stock_quantity - ci.quantity
WHERE ci.cart_id = 10;

-- Re-validate stock is not negative
SELECT COUNT(*) FROM books WHERE stock_quantity < 0;
-- If count > 0, ROLLBACK

-- STEP 6: Update coupon usage
UPDATE coupons
SET usage_count = usage_count + 1
WHERE code = 'SAVE10';

-- STEP 7: Record user interactions
INSERT INTO user_book_interactions (user_id, book_id, action, weight, count, last_interacted_at, created_at, updated_at)
SELECT 5, oi.book_id, 'purchase', 10, 1, NOW(), NOW(), NOW()
FROM order_items oi
WHERE oi.order_id = 500
ON DUPLICATE KEY UPDATE
    count = count + 1,
    last_interacted_at = NOW(),
    updated_at = NOW();

-- STEP 8: Clear cart
DELETE FROM cart_items WHERE cart_id = 10;

-- Commit transaction
COMMIT;
```

---

## Stage 5: Payment Processing

### ToyyibPay Integration Flow

```
┌──────────────────────────────────────────────────────────────┐
│  PAYMENT BILL CREATION (after order created)                │
└──────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │  Orders  │ id=500, status='pending', payment_status='pending'
    └────┬─────┘
         │
         │ pass to ToyyibPayService
         ↓
    
    ┌──────────────────────┐
    │  ToyyibPayService    │
    │  ::createBill()      │
    └──────────────────────┘
         │
         │ API Call with:
         │ • categoryCode (from config)
         │ • billName = "Order #ORD-20250102-XYZ123"
         │ • billDescription = "Payment for 3 items"
         │ • billPriceSetting = 1 (fixed price)
         │ • billAmount = 14500 (in cents: 145.00 × 100)
         │ • billReturnUrl = route('toyyibpay.return')
         │ • billCallbackUrl = route('toyyibpay.callback')
         │ • billExternalReferenceNo = 'ORD-20250102-XYZ123'
         │ • billTo = user name
         │ • billEmail = user email
         │ • billPhone = user phone
         ↓
    
    ┌──────────────────────┐
    │   ToyyibPay API      │ (External Service)
    └──────────────────────┘
         │
         │ Returns:
         │ [
         │   {
         │     BillCode: "abc123xyz"
         │   }
         │ ]
         ↓
    
    ┌──────────┐
    │  Orders  │ ◄─── UPDATE
    └──────────┘
         │
         ├─► toyyibpay_bill_code = 'abc123xyz'
         └─► toyyibpay_payment_url = 'https://toyyibpay.com/abc123xyz'

    User redirected to: toyyibpay_payment_url


┌──────────────────────────────────────────────────────────────┐
│  USER COMPLETES PAYMENT ON TOYYIBPAY                        │
└──────────────────────────────────────────────────────────────┘

    User on ToyyibPay website:
         │
         ├─► Enters payment details
         ├─► Confirms payment
         └─► ToyyibPay processes payment


┌──────────────────────────────────────────────────────────────┐
│  PAYMENT CALLBACK (Server-to-Server)                        │
└──────────────────────────────────────────────────────────────┘

    ToyyibPay sends POST to: route('toyyibpay.callback')
         │
         │ payload:
         │ {
         │   billcode: 'abc123xyz',
         │   order_id: 'ORD-20250102-XYZ123',
         │   status_id: 1, // 1=success, 2=pending, 3=failed
         │   reason_id: '...',
         │   amount: 14500,
         │   billpaymentdate: '2025-01-02 15:30:00'
         │ }
         ↓
    
    ToyyibPayController@callback
         │
         ├─► Find order: Orders WHERE public_id = 'ORD-20250102-XYZ123'
         │
         ├─► Validate: toyyibpay_bill_code matches
         │
         └─► UPDATE based on status_id:

            IF status_id = 1 (success):
                ┌──────────┐
                │  Orders  │ ◄─── UPDATE
                └──────────┘
                     │
                     ├─► status = 'processing'
                     ├─► payment_status = 'paid'
                     ├─► payment_date = billpaymentdate
                     ├─► toyyibpay_payment_status = 1
                     └─► updated_at = NOW()

            ELSE IF status_id = 2 (pending):
                ┌──────────┐
                │  Orders  │ ◄─── UPDATE
                └──────────┘
                     │
                     ├─► status = 'pending'
                     ├─► payment_status = 'pending'
                     └─► toyyibpay_payment_status = 2

            ELSE IF status_id = 3 (failed):
                ┌──────────┐
                │  Orders  │ ◄─── UPDATE
                └──────────┘
                     │
                     ├─► status = 'failed'
                     ├─► payment_status = 'failed'
                     └─► toyyibpay_payment_status = 3


┌──────────────────────────────────────────────────────────────┐
│  RETURN URL (Browser Redirect)                              │
└──────────────────────────────────────────────────────────────┘

    ToyyibPay redirects user's browser to: route('toyyibpay.return')
         │
         │ query params:
         │ ?status_id=1&billcode=abc123xyz&order_id=ORD-20250102-XYZ123
         ↓
    
    ToyyibPayController@return
         │
         ├─► Find order: Orders WHERE public_id = 'ORD-20250102-XYZ123'
         │
         └─► Redirect user based on status:
                 │
                 ├─► IF payment successful:
                 │   redirect to order confirmation page
                 │   with success message
                 │
                 ├─► IF payment pending:
                 │   redirect to order page
                 │   with pending message
                 │
                 └─► IF payment failed:
                     redirect to checkout
                     with error message
```

---

## Stage 6: Post-Purchase

### Order Management Entities

```
┌──────────────────────────────────────────────────────────────┐
│  ORDER TRACKING & UPDATES                                    │
└──────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │   User   │ id=5
    └────┬─────┘
         │
         │ can view own orders
         ↓
    ┌──────────┐
    │  Orders  │ WHERE user_id = 5
    └────┬─────┘
         │
         │ has many
         ↓
    ┌───────────────┐      ┌──────────┐
    │  Order_Items  │─────►│  Books   │ (reference, not modified)
    └───────────────┘      └──────────┘
         │
         │ snapshot prices preserved
         │ (even if book.price changes later)
         │
         └─► price = 75.00 (at purchase time)
             cost_price = 50.00 (at purchase time)

    ┌──────────┐
    │  Orders  │
    └──────────┘
         │
         │ references
         ↓
    ┌────────────────────────┐
    │Postage_Rate_History    │ (snapshot at purchase time)
    └────────────────────────┘


┌──────────────────────────────────────────────────────────────┐
│  ADMIN ORDER MANAGEMENT                                      │
└──────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │  Admin   │ (User with admin/superadmin role)
    └────┬─────┘
         │
         │ has role
         ↓
    ┌──────────┐      ┌───────────────┐
    │  Roles   │─────►│  Permissions  │
    └──────────┘      └───────────────┘
         │                    │
         │                    ├─► order.view
         │                    ├─► order.update
         │                    └─► order.delete
         │
         └─► Can access: Admin\OrderController

    Admin can UPDATE:
    ┌──────────┐
    │  Orders  │
    └──────────┘
         │
         └─► status: pending → processing → shipped → completed
             or: cancelled, failed


┌──────────────────────────────────────────────────────────────┐
│  RECOMMENDATION SYSTEM UPDATES                               │
└──────────────────────────────────────────────────────────────┘

    After successful purchase:
    
    ┌────────────────────────┐
    │ User_Book_Interactions │
    └────────────────────────┘
         │
         │ Records for each purchased book:
         │
         ├─► action = 'purchase'
         ├─► weight = 10 (highest weight)
         ├─► count = count + 1
         └─► last_interacted_at = NOW()

    ┌──────────────────────────┐
    │  RecommendationService   │
    └──────────────────────────┘
         │
         └─► Uses purchase data to:
             • Find similar books
             • Recommend based on genres/tropes
             • Show "Customers who bought this also bought..."


┌──────────────────────────────────────────────────────────────┐
│  ANALYTICS & REPORTING                                       │
└──────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │  Orders  │
    └────┬─────┘
         │
         ├─► total_amount → Revenue tracking
         ├─► discount_amount → Coupon effectiveness
         ├─► shipping_customer_price → Shipping revenue
         └─► shipping_actual_cost → Shipping cost

    ┌───────────────┐
    │  Order_Items  │
    └───────┬───────┘
            │
            ├─► price × quantity → Item revenue
            ├─► cost_price × quantity → Cost of goods sold (COGS)
            └─► (price - cost_price) × quantity → Gross profit

    ┌────────────────────────┐
    │Postage_Rate_History    │
    └────────────────────────┘
            │
            └─► Track historical shipping costs
                (even if current rates change)
```

---

## Entity State Transitions

### Cart Entity States

```
┌────────────────────────────────────────────────────────────┐
│  CART LIFECYCLE                                            │
└────────────────────────────────────────────────────────────┘

    [User Registers]
            │
            ↓
    ┌────────────────┐
    │  Cart Created  │ (automatically on first "Add to Cart")
    │  (EMPTY)       │
    └───────┬────────┘
            │
            ↓
    ┌────────────────┐
    │  Cart + Items  │ ◄──┐ (user adds/removes items)
    │  (ACTIVE)      │ ───┘
    └───────┬────────┘
            │
            │ user proceeds to checkout
            ↓
    ┌────────────────┐
    │  Cart Items    │ (read during checkout)
    │  (VALIDATED)   │
    └───────┬────────┘
            │
            │ order created successfully
            ↓
    ┌────────────────┐
    │  Cart Cleared  │ (items deleted)
    │  (EMPTY)       │ ◄──┐
    └───────┬────────┘    │
            │             │
            │             │ user adds new items for next purchase
            └─────────────┘

    IMPORTANT: Cart entity itself is NEVER deleted!
    Only cart_items are deleted after order creation.
    Same cart is reused for all future purchases.
```

### Order Entity States

```
┌────────────────────────────────────────────────────────────┐
│  ORDER STATUS FLOW                                         │
└────────────────────────────────────────────────────────────┘

    [Order Created]
            │
            ↓
    ┌────────────────┐
    │   PENDING      │ (awaiting payment)
    │ payment:pending│
    └───────┬────────┘
            │
            ├─► ToyyibPay Bill Created
            ├─► User redirected to payment gateway
            │
            ↓
    ┌─────────────────────────────────┐
    │  PAYMENT OUTCOME                │
    └─────────────────────────────────┘
            │
            ├──► [Payment Success]
            │         │
            │         ↓
            │    ┌────────────────┐
            │    │  PROCESSING    │ (order confirmed, preparing)
            │    │  payment:paid  │
            │    └───────┬────────┘
            │            │
            │            │ admin updates
            │            ↓
            │    ┌────────────────┐
            │    │   SHIPPED      │ (in transit)
            │    │  payment:paid  │
            │    └───────┬────────┘
            │            │
            │            │ admin confirms
            │            ↓
            │    ┌────────────────┐
            │    │  COMPLETED     │ (delivered successfully)
            │    │  payment:paid  │
            │    └────────────────┘
            │
            ├──► [Payment Pending]
            │         │
            │         ↓
            │    ┌────────────────┐
            │    │   PENDING      │ (still awaiting confirmation)
            │    │payment:pending │
            │    └────────────────┘
            │
            └──► [Payment Failed]
                      │
                      ↓
                 ┌────────────────┐
                 │    FAILED      │ (payment unsuccessful)
                 │ payment:failed │
                 └────────────────┘

    ADMIN CAN ALSO:
            │
            ├──► Manually set: CANCELLED (by customer request)
            └──► Manually set: REFUNDED (after refund processing)
```

### Book Entity Stock State

```
┌────────────────────────────────────────────────────────────┐
│  BOOK STOCK LIFECYCLE                                      │
└────────────────────────────────────────────────────────────┘

    Initial State:
    ┌──────────────────────┐
    │  Book                │
    │  stock_quantity: 100 │
    │  is_available: true  │
    └──────────────────────┘

    User adds 2 to cart:
    ┌──────────────────────┐
    │  Book                │ (no change yet)
    │  stock_quantity: 100 │
    │  is_available: true  │
    └──────────────────────┘
    │
    │ (Stock only checked, not deducted at cart stage)
    │
    └─► Cart_Item: quantity=2 (reserved conceptually, not DB-level)

    User completes checkout:
    ┌──────────────────────┐
    │  Book                │ ◄─── UPDATED (inside transaction)
    │  stock_quantity: 98  │ (100 - 2)
    │  is_available: true  │
    └──────────────────────┘
    │
    └─► Stock deducted ONLY after successful order creation

    If stock reaches 0:
    ┌──────────────────────┐
    │  Book                │
    │  stock_quantity: 0   │
    │  is_available: false │ ◄─── Admin may set to false
    └──────────────────────┘
    │
    └─► Book not purchasable until restocked
```

---

## Data Flow Summary

### Complete Purchase Journey

```
┌═══════════════════════════════════════════════════════════════════════════════┐
║                    DATA FLOW: START TO END                                    ║
└═══════════════════════════════════════════════════════════════════════════════┘

1. USER BROWSES
   User → Books (+ Genres, Tropes, Reviews, Flash_Sales, Book_Discounts)
   
2. USER ADDS TO CART
   User → Cart (created if not exists)
   Cart → Cart_Items (created/updated)
   Cart_Items → Books (FK reference)
   User_Book_Interactions (records "add_to_cart")
   
3. USER PROCEEDS TO CHECKOUT
   User → Cart → Cart_Items → Books
   Postage_Rates (loaded for shipping options)
   User profile (auto-fill form)
   
4. USER APPLIES COUPON (optional)
   Coupons (validated via API)
   → discount_amount calculated
   → free_shipping flag set
   
5. USER SUBMITS ORDER
   ┌─── Transaction Start ───┐
   │                          │
   │ Cart_Items → Books       │ (lock & validate stock)
   │                          │
   │ Postage_Rates →          │
   │   Postage_Rate_History   │ (snapshot created)
   │                          │
   │ Orders (new record)      │
   │   ├─► user_id (FK)       │
   │   └─► postage_rate_...   │
   │                          │
   │ Cart_Items →             │
   │   Order_Items (copied)   │ (with snapshot prices)
   │   ├─► order_id (FK)      │
   │   └─► book_id (FK)       │
   │                          │
   │ Books.stock_quantity     │ (reduced)
   │                          │
   │ Coupons.usage_count      │ (incremented if used)
   │                          │
   │ User_Book_Interactions   │ (records "purchase")
   │                          │
   │ Cart_Items (deleted)     │
   │                          │
   └─── Transaction Commit ───┘
   
6. PAYMENT PROCESSING
   Order → ToyyibPayService
   ToyyibPay API (external)
   → bill_code returned
   Order.toyyibpay_bill_code (updated)
   User redirected to payment page
   
7. PAYMENT CALLBACK
   ToyyibPay → ToyyibPayController@callback
   Order (updated based on payment status)
   
8. POST-PURCHASE
   User views Order history
   Admin manages Order status
   RecommendationService uses User_Book_Interactions
   Analytics queries Orders, Order_Items, Postage_Rate_History
```

### Entity Relationship Flow Chart

```
                    ┌──────────────┐
                    │     User     │
                    └──────┬───────┘
                           │
            ┌──────────────┼──────────────┐
            │              │              │
            │              │              │
       (owns 1)      (places many)   (interacts)
            │              │              │
            ↓              ↓              ↓
       ┌─────────┐    ┌─────────┐   ┌──────────────────────┐
       │  Cart   │    │ Orders  │   │User_Book_Interactions│
       └────┬────┘    └────┬────┘   └──────────────────────┘
            │              │
      (has many)     (has many)
            │              │
            ↓              ↓
    ┌──────────────┐  ┌───────────────┐
    │  Cart_Items  │  │  Order_Items  │
    └──────┬───────┘  └───────┬───────┘
           │                  │
           └────────┬─────────┘
                    │
              (references)
                    │
                    ↓
            ┌──────────────┐
            │    Books     │
            └──────┬───────┘
                   │
        ┌──────────┼──────────┐
        │          │          │
   (has many) (has many) (has many)
        │          │          │
        ↓          ↓          ↓
   ┌─────────┐ ┌─────────┐ ┌──────────────┐
   │Book_Genre│ │Book_Trope│ │Book_Discounts│
   └────┬─────┘ └────┬─────┘ └──────────────┘
        │            │
        │            │
        ↓            ↓
   ┌────────┐   ┌────────┐
   │ Genres │   │ Tropes │
   └────────┘   └────────┘

   Orders also references:
        │
        ├──► Postage_Rate_History (FK)
        ├──► Coupons (code, not FK)
        └──► ToyyibPay (bill_code, external)
```

---

## Key Takeaways

### 1. **No Cart → Order Direct Relationship**
- Cart and Order exist at different times
- Data is **copied**, not referenced
- Cart is **cleared and reused** after each order

### 2. **Atomic Order Creation**
- All entities updated in **single transaction**
- **Row locking** prevents race conditions
- **Rollback** on any failure ensures data integrity

### 3. **Snapshot Pattern**
- Prices captured in `Order_Items` at purchase time
- Postage rates captured in `Postage_Rate_History`
- Historical accuracy preserved even if base data changes

### 4. **Entity Responsibilities**
- **Cart/Cart_Items**: Temporary staging (pre-purchase)
- **Orders/Order_Items**: Permanent record (post-purchase)
- **Books**: Inventory management (stock tracking)
- **Postage_Rate_History**: Shipping cost tracking
- **User_Book_Interactions**: Recommendation data

### 5. **Data Flow Direction**
```
User → Cart → [Checkout] → Order → Payment → Completion
                ↓
           Cart cleared, Order persists
```

---

## Files Referenced

- `app/Models/User.php` - User entity
- `app/Models/Cart.php` - Cart entity
- `app/Models/CartItem.php` - CartItem entity
- `app/Models/Book.php` - Book entity
- `app/Models/Order.php` - Order entity
- `app/Models/OrderItem.php` - OrderItem entity
- `app/Models/Coupon.php` - Coupon entity
- `app/Models/PostageRate.php` - PostageRate entity
- `app/Models/PostageRateHistory.php` - PostageRateHistory entity
- `app/Models/UserBookInteraction.php` - UserBookInteraction entity
- `app/Http/Controllers/CartController.php` - Cart management
- `app/Http/Controllers/CheckoutController.php` - Checkout & order creation
- `app/Http/Controllers/ToyyibPayController.php` - Payment processing
- `app/Services/ToyyibPayService.php` - Payment gateway integration

---

**Document Created**: 2025-01-02  
**System**: Bookty E-Commerce Platform  
**Purpose**: Visual guide for entity interactions during purchase flow
