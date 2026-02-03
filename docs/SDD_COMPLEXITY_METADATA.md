# Software Design Documentation (SDD) — Complexity Metadata

**Document Purpose:** Extract complexity-related metadata from system documentation for SDD purposes.  
**Source Documents:** Use Case Diagram, System Architecture, System Requirements, Controllers, Models, Hybrid Recommendation Service documentation.  
**Constraints:** Information derived only from explicitly stated or clearly inferable documentation. Missing information is stated as "Not specified in the documentation."

---

## 1. Core System Modules

The Bookty e-commerce platform is organised into the following main modules or subsystems:

| Module | Description | Layer |
|--------|-------------|-------|
| **User Interface** | Routes, Controllers, Views (Blade), API Endpoints, Middleware | Presentation |
| **Domain** | Services, Business Logic in Models, Observers, Form Requests, Exports | Business Logic |
| **Data Access** | Eloquent Models, Migrations, Query Builder, Cache | Persistence |
| **Authentication** | Login, Register, Password Reset, Role-based Access | Cross-cutting |
| **Recommendation** | Hybrid recommendation engine (content-based + collaborative filtering) | Domain |
| **Checkout & Payment** | Cart, Checkout flow, Coupon validation, ToyyibPay integration | Domain |
| **Admin Management** | Books, Orders, Coupons, Reports, Customers | Domain |
| **Superadmin** | Admin users, Roles, Permissions, System Settings | Domain |

---

## 2. Functional Complexity Metadata

| Module | Main Function | Inputs | Outputs | Dependencies | Complexity | Justification |
|--------|---------------|--------|---------|--------------|------------|---------------|
| **RecommendationService** | Generate personalised book recommendations | User, limit (int) | Collection of Book models with score attribute | Book, OrderItem, UserBookInteraction, User models; Cache | **High** | Multi-stage algorithm (content-based + collaborative), weighted fusion, cold-start fallback, caching logic |
| **CheckoutController** | Process purchase and payment | Request (shipping info, cart) | Order creation, redirect to payment URL | PostageRateService, Coupon model, Order/OrderItem models, ToyyibPayService | **High** | Orchestrates validation, postage, coupon, order creation, and external payment; transactional flow |
| **Coupon (Model)** | Validate and calculate discount | User, order amount | Boolean (validity), float (discount amount) | CouponUsage model | **Medium** | Rule-based validation (active, dates, min amount, max uses per user/total); discount calculation (fixed/percentage/free shipping) |
| **PostageRateService** | Provide postage rates by region | Region | PostageRateHistory record | PostageRate, PostageRateHistory models | **Medium** | Region-based lookup, history tracking |
| **BookController (Customer)** | Browse and display books | Request (filters, sort) | Paginated book list, book detail view | Book, Genre, Trope models | **Low** | Standard CRUD with filter/sort; related books lookup |
| **CartController** | Manage shopping cart | Request, Book/CartItem | Cart state | Cart, CartItem, Book models | **Low** | Add/update/remove; stock validation |
| **ReportsController** | Generate admin reports | Request (date range, filters) | Tables, charts, Excel export | Multiple models; Query Builder; ProfitabilityReportExport, SalesReportExport | **High** | Multiple report types (sales, customers, inventory, promotions, profitability); complex queries; export logic |
| **RecommendationAnalyticsController** | Display recommendation metrics | — | Dashboard view | RecommendationService, UserBookInteraction, OrderItem | **Medium** | Aggregates genre/trope/author match rates, precision, recall, F1; settings management |
| **Admin Controllers (CRUD)** | Manage books, genres, tropes, orders, coupons | Request | CRUD operations | Respective models | **Low–Medium** | Standard resource operations; BookController includes image upload and trope sync |
| **Superadmin Controllers** | Manage admins, roles, permissions | Request | CRUD operations | User, Role, Permission (Spatie) | **Medium** | RBAC configuration; role–permission matrix |

---

## 3. Algorithmic / Decision Logic Complexity

### 3.1 Recommendation Logic (RecommendationService)

| Component | Logic Type | Conceptual Description |
|-----------|------------|-------------------------|
| **Content-based scoring** | Weighted scoring, rule-based | Builds user preference profile from purchased books, wishlist, and interactions (view, click, cart, wishlist). Each action has a weight (1.0–5.0). Implicit feedback is scaled (×0.3) and capped (≤2.0). For each candidate book, score = genre match (1.0) + trope overlap (0.6 per trope) + author match (0.4) + popularity term (0.05 × review count). Scores are max-normalised to [0, 1]. |
| **Collaborative scoring** | Co-purchase frequency | Identifies peers (users who bought at least one of the target user’s purchased books). For each book not purchased by the user, score = count of peers who purchased it. Top 200 books retained; scores max-normalised. |
| **Hybrid fusion** | Weighted combination | `finalScore = 0.6 × contentScore + 0.4 × collaborativeScore`. Weights configurable via admin settings. Books ranked by finalScore descending. |
| **Cold-start fallback** | Decision rule | If both content and collaborative scores are empty, return popular books (ordered by review count, then recency). |
| **similarToBook()** | Content-based only | Item-to-item similarity using genre, trope, and author overlap; no user context. |

### 3.2 Coupon Validation Logic (Coupon Model)

| Rule | Description |
|------|-------------|
| Active check | Coupon must be `is_active`. |
| Date range | Current time must be between `starts_at` and `expires_at`. |
| Minimum purchase | If set, order amount must be ≥ `min_purchase_amount`. |
| Max total uses | If set, total usages must be &lt; `max_uses_total`. |
| Max per user | If set, user’s usages must be &lt; `max_uses_per_user`. |
| Discount calculation | Fixed: min(discount_value, orderAmount); Percentage: (orderAmount × discount_value) / 100; Free shipping only: 0.0 (handled separately). |

### 3.3 Other Decision Logic

| Component | Logic Type | Description |
|-----------|------------|-------------|
| **BookObserver** | Event-driven | Clears recommendation cache when books are created, updated, or deleted. |
| **Dashboard redirect** | Role-based routing | Superadmin → `/superadmin`; Admin → `/admin`; else home. |
| **Stock validation** | Rule-based | Quantity added to cart cannot exceed available stock. |

---

## 4. Structural Complexity Metadata

| Controller / Class | Responsibilities | Dependencies | Responsibility Scope | Justification |
|--------------------|------------------|--------------|------------------------|---------------|
| **CheckoutController** | Validate shipping; create order; apply coupon; calculate postage; integrate payment gateway | PostageRateService, Coupon, Order, OrderItem, ToyyibPayService | **High** | Orchestrates multiple services and models; payment integration; transactional order creation |
| **RecommendationService** | Content-based scoring; collaborative scoring; hybrid fusion; cold-start; caching | Book, OrderItem, UserBookInteraction, User, Cache | **High** | Core recommendation logic; multiple internal methods; cache management |
| **ReportsController** | Sales, customer, inventory, promotion, profitability reports; Excel export | Multiple models; Query Builder; Export classes | **High** | Multiple report types; complex queries; export logic |
| **RecommendationAnalyticsController** | Display metrics; manage algorithm settings | RecommendationService, interaction/order data | **Medium** | Analytics aggregation; settings persistence |
| **HomeController** | Homepage; new arrivals; genres; recommendations | RecommendationService, Book, Genre | **Medium** | Composes multiple data sources; recommendation integration |
| **BookController (Admin)** | CRUD; image upload; trope sync | Book, Genre, Trope | **Medium** | Standard CRUD plus file upload and many-to-many sync |
| **OrderController (Admin)** | Order list; status updates | Order, OrderItem | **Low–Medium** | Standard resource with status transitions |
| **CouponController** | CRUD; validation API | Coupon, CouponUsage | **Low** | Standard CRUD; API validation delegate |
| **CartController** | Add, update, remove cart items | Cart, CartItem, Book | **Low** | Focused cart operations |
| **ProfileController** | Profile edit; orders; order detail | User, Order | **Low** | Profile and order display |

---

## 5. Data Complexity Metadata

### 5.1 Key Entities and Relationships

| Entity | Table | Relationships | Cardinality |
|--------|-------|---------------|-------------|
| **User** | users | orders, cart, reviews, wishlist, coupon_usages | One-to-many |
| **Book** | books | genre, tropes, orderItems, cartItems, reviews, wishlist, user_book_interactions | One-to-many; Many-to-many (tropes) |
| **Order** | orders | user, items (OrderItem), coupon | One-to-many |
| **OrderItem** | order_items | order, book | Many-to-one |
| **Cart** | carts | user, items (CartItem) | One-to-many |
| **CartItem** | cart_items | cart, book | Many-to-one |
| **Coupon** | coupons | usages (CouponUsage) | One-to-many |
| **CouponUsage** | coupon_usages | coupon, user, order | Many-to-one (each) |
| **FlashSale** | flash_sales | books (via flash_sale_items) | Many-to-many |
| **Genre** | genres | books | One-to-many |
| **Trope** | tropes | books (via book_trope) | Many-to-many |
| **Review** | reviews | user, book | Many-to-one (each) |
| **Wishlist** | wishlists | user, book | Many-to-one (each) |
| **PostageRate** | postage_rates | history (PostageRateHistory) | One-to-many |
| **UserBookInteraction** | user_book_interactions | user, book | Many-to-one (each) |

### 5.2 Entities with Higher Relational Complexity

| Entity | Complexity | Reason |
|--------|------------|--------|
| **Book** | **High** | Participates in many relationships: genre, tropes, orderItems, cartItems, reviews, wishlist, user_book_interactions, flash_sale_items, book_discounts. Central to catalog, recommendations, and sales. |
| **User** | **High** | Links to orders, cart, reviews, wishlist, coupon_usages, roles, permissions. Central to authentication and RBAC. |
| **Order** | **Medium** | Links to user, order_items, coupon; status and payment state; used in reports and recommendations. |
| **Coupon** | **Medium** | Links to CouponUsage (user, order); validation rules span multiple entities. |

---

## 6. External Dependency Metadata

| Integration | Type | Purpose | Documentation Reference |
|-------------|------|---------|-------------------------|
| **ToyyibPay / FPX** | Payment gateway API | Process payment; create bill; receive callback | SYSTEM_ARCHITECTURE.md; Use Case Diagram (UC56, UC57); ToyyibPayService |
| **Google OAuth** | Authentication API | Google OAuth Login (UC8) | system-overview.puml; Use Case Diagram |
| **Email Service** | Not specified | Password reset; verification | system-overview.puml |
| **MySQL / MariaDB** | Database | Persistence | SYSTEM_ARCHITECTURE.md |
| **Spatie Laravel Permission** | Third-party package | Roles and permissions (RBAC) | SYSTEM_ARCHITECTURE.md; migrations |
| **Laravel Cache** | Framework | Recommendation caching (30 min TTL) | RecommendationService; NFR-01 |
| **File Storage** | Storage | Cover images; review images | system-overview.puml |

### Integration Notes

- **ToyyibPay:** Checkout flow includes `createToyyibPayBill()`; payment callback and status return are documented in the Use Case Diagram.
- **Google OAuth:** Actor and use case (UC8) are documented; implementation details are not specified.
- **Email Service:** Referenced in system overview; provider and configuration not specified.

---

## Summary

The Bookty system exhibits **high functional complexity** in the Recommendation and Checkout modules due to multi-stage algorithms, rule-based validation, and external integrations. **Structural complexity** is highest in CheckoutController, RecommendationService, and ReportsController. **Data complexity** is highest for Book and User, which participate in many relationships. External dependencies include ToyyibPay, Google OAuth, and Spatie Laravel Permission.

---

*This document is derived from the Bookty Management System documentation. It is intended for Software Design Documentation (SDD) and Final Year Project (FYP) purposes.*
