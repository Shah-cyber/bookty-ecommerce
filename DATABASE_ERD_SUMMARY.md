# Bookty E-Commerce - Database ERD Quick Reference

## 📚 Documentation Files

1. **`DATABASE_ERD.md`** - Complete detailed ERD with all entities, relationships, and descriptions
2. **`DATABASE_ERD.dbml`** - dbdiagram.io format (import at https://dbdiagram.io/)
3. **`DATABASE_ERD_VISUAL.txt`** - Visual guide for manual diagram creation
4. **`DATABASE_ERD_SUMMARY.md`** - This file (quick reference)

---

## 🗂️ Entity Count: 19 Tables

### Core (4)
- `users`, `genres`, `tropes`, `books`

### Shopping (5)
- `carts`, `cart_items`, `orders`, `order_items`, `wishlists`

### Promotions (5)
- `coupons`, `coupon_usages`, `book_discounts`, `flash_sales`, `flash_sale_items`

### Reviews (3)
- `reviews`, `review_helpfuls`, `review_reports`

### System (2)
- `postage_rates`, `settings`

---

## 🔗 Key Relationships

### One-to-Many
```
users → orders, carts, reviews, wishlists
genres → books
books → cart_items, order_items, reviews, wishlists
carts → cart_items
orders → order_items, coupon_usages
coupons → orders, coupon_usages
flash_sales → flash_sale_items
reviews → review_helpfuls, review_reports
```

### Many-to-Many
```
books ↔ tropes (via book_trope)
books ↔ flash_sales (via flash_sale_items)
users ↔ books (via wishlists)
```

### One-to-One
```
users → carts (1:1)
books → book_discounts (1:1, active)
order_items → reviews (1:1, optional)
```

---

## 🔑 Important Design Patterns

### 1. Denormalization
- **Orders** store shipping prices (not FK to `postage_rates`)
- **Order Items** store book prices (not FK to current `books` prices)
- **Reason**: Historical accuracy

### 2. Unique Constraints
- `wishlists`: `(user_id, book_id)`
- `book_trope`: `(book_id, trope_id)`
- `flash_sale_items`: `(flash_sale_id, book_id)`
- `reviews.order_item_id`: Unique (one review per order item)

### 3. Cascade Deletes
- `cart_items` when `carts` deleted
- `order_items` when `orders` deleted
- `wishlists` when `users` or `books` deleted
- `flash_sale_items` when `flash_sales` or `books` deleted

---

## 📊 Quick Entity Reference

| Entity | Primary Key | Key Foreign Keys | Notes |
|--------|-------------|-----------------|-------|
| `users` | `id` | - | Has roles/permissions (Spatie) |
| `genres` | `id` | - | Book categories |
| `tropes` | `id` | - | Story themes |
| `books` | `id` | `genre_id` | Main product |
| `carts` | `id` | `user_id` (unique) | One per user |
| `cart_items` | `id` | `cart_id`, `book_id` | Cart line items |
| `orders` | `id` | `user_id`, `coupon_id` (nullable) | Customer orders |
| `order_items` | `id` | `order_id`, `book_id` | Order line items |
| `wishlists` | `id` | `user_id`, `book_id` | User wishlists |
| `coupons` | `id` | - | Discount codes |
| `coupon_usages` | `id` | `coupon_id`, `user_id`, `order_id` | Usage tracking |
| `book_discounts` | `id` | `book_id` (unique) | Per-book discounts |
| `flash_sales` | `id` | - | Time-limited sales |
| `flash_sale_items` | `id` | `flash_sale_id`, `book_id` | Books in sales |
| `reviews` | `id` | `user_id`, `book_id`, `order_item_id` (nullable) | Product reviews |
| `review_helpfuls` | `id` | `review_id`, `user_id` | Helpful votes |
| `review_reports` | `id` | `review_id`, `user_id`, `admin_id` (nullable) | Moderation |
| `postage_rates` | `id` | - | Shipping rates (no FK) |
| `settings` | `id` | - | System config |

---

## 🎯 Entity Groups

### Customer-Facing
- `users`, `carts`, `cart_items`, `orders`, `order_items`, `wishlists`, `reviews`

### Product Catalog
- `genres`, `tropes`, `books`, `book_trope`

### Promotions
- `coupons`, `coupon_usages`, `book_discounts`, `flash_sales`, `flash_sale_items`

### Review System
- `reviews`, `review_helpfuls`, `review_reports`

### System
- `postage_rates`, `settings`

---

## 📝 Special Notes

1. **No PostageRate FK**: Orders don't reference `postage_rates` - values are copied for history
2. **Denormalized Pricing**: Order items store prices at time of order
3. **Optional Relationships**: Orders may not have coupons, reviews may not link to order items
4. **Spatie Permissions**: Additional tables for roles/permissions (not detailed in main ERD)

---

## 🛠️ Tools to Visualize

1. **dbdiagram.io** - Import `DATABASE_ERD.dbml`
2. **draw.io** - Use `DATABASE_ERD_VISUAL.txt` as guide
3. **MySQL Workbench** - Reverse engineer from database
4. **Lucidchart** - Manual creation using `DATABASE_ERD.md`

---

## 📈 Statistics

- **Total Tables**: 19
- **Pivot Tables**: 3 (`book_trope`, `flash_sale_items`, `wishlists`)
- **One-to-Many**: 15 relationships
- **Many-to-Many**: 3 relationships
- **One-to-One**: 3 relationships
- **Optional FKs**: 3 (`orders.coupon_id`, `reviews.order_item_id`, `review_reports.admin_id`)

---

For complete details, see **`DATABASE_ERD.md`** 📖

