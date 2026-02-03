# Bookty Management System - System Architecture

This document describes the system architecture of the Bookty e-commerce platform, organized into three main layers: **User Interface**, **Domain Layer**, and **Data Access Layer**.

---

## Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                         USER INTERFACE LAYER                                  │
│  Routes │ Controllers │ Views (Blade) │ API Endpoints │ Middleware            │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                          DOMAIN LAYER                                         │
│  Services │ Business Logic in Models │ Observers │ Request Validation       │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                       DATA ACCESS LAYER                                       │
│  Eloquent Models │ Migrations │ Query Builder │ Cache                        │
└─────────────────────────────────────────────────────────────────────────────┘
                                    │
                                    ▼
┌─────────────────────────────────────────────────────────────────────────────┐
│                         DATABASE                                               │
│  MySQL / MariaDB (Laravel default)                                            │
└─────────────────────────────────────────────────────────────────────────────┘
```

---

## 1. User Interface Layer (Presentation Layer)

The User Interface Layer handles all user interactions, request routing, and response rendering.

### 1.1 Routes (`routes/`)

| Route File | Purpose | Key Routes |
|------------|---------|------------|
| `web.php` | Web application routes | Home, Books, Cart, Checkout, Profile, Admin, Superadmin |
| `auth.php` | Authentication routes | Login, Register, Password Reset |

**Route Groups by Actor:**

| Actor | Prefix | Middleware | Examples |
|-------|--------|------------|----------|
| Guest | `/` | None | Home, Books, About, Contact |
| Customer | `/` | `auth` | Cart, Checkout, Profile, Wishlist |
| Admin | `/admin` | `auth`, `role:admin\|superadmin`, `permission:*` | Books, Orders, Coupons, Reports |
| Superadmin | `/superadmin` | `auth`, `role_or_permission:superadmin` | Admins, Roles, Permissions |

### 1.2 Controllers (`app/Http/Controllers/`)

| Controller Group | Responsibility | Key Controllers |
|------------------|----------------|-----------------|
| **Customer** | Public & customer-facing | HomeController, BookController, CartController, CheckoutController, ProfileController |
| **Auth** | Authentication & registration | AuthenticatedSessionController, RegisteredUserController, PasswordController |
| **Admin** | Admin operations | BookController, OrderController, CouponController, FlashSaleController, ReportsController |
| **SuperAdmin** | System administration | AdminController, RoleController, PermissionController |
| **Api** | JSON/API endpoints | RecommendationController, CouponController, PostageController |

**Controller Responsibilities:**
- Receive HTTP requests
- Validate input (via Form Requests)
- Delegate business logic to Services or Models
- Return views or JSON responses

### 1.3 Views (`resources/views/`)

| View Directory | Purpose |
|----------------|---------|
| `layouts/` | Base layouts (app, admin, superadmin, guest) |
| `home/` | Homepage with hero, recommendations, genre gallery |
| `books/` | Book listing and details |
| `cart/` | Shopping cart |
| `checkout/` | Checkout flow |
| `profile/` | User profile, orders, invoice |
| `auth/` | Login, register, password reset |
| `admin/` | Admin CRUD (books, orders, coupons, reports) |
| `superadmin/` | Admin management, roles, permissions |
| `components/` | Reusable UI components (book-card, auth-modal) |

### 1.4 API Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/recommendations/me` | GET | Personalized recommendations (auth required) |
| `/api/recommendations/similar/{book}` | GET | Similar books (public) |
| `/api/coupons/validate` | POST | Validate coupon code |
| `/api/postage/calculate` | POST | Calculate shipping cost |

### 1.5 Middleware (`app/Http/Middleware/`)

| Middleware | Purpose |
|------------|---------|
| `Authenticate` | Redirect unauthenticated users to login |
| `EnsureUserHasCart` | Ensure cart exists for checkout |
| `role:admin\|superadmin` | Restrict access by role |
| `permission:*` | Restrict access by permission (e.g., view books, manage orders) |

---

## 2. Domain Layer (Business Logic Layer)

The Domain Layer contains business rules, application logic, and orchestration.

### 2.1 Services (`app/Services/`)

| Service | Responsibility |
|---------|----------------|
| **RecommendationService** | Hybrid recommendation engine (content-based + collaborative filtering), caching, cold-start fallback |
| **PostageRateService** | Postage rate updates, history tracking, region-based pricing |
| **ToyyibPayService** | Payment gateway integration (ToyyibPay/FPX) |

**Service Usage Example:**
```php
// HomeController uses RecommendationService
$recommendations = $this->recommendationService->recommendForUser(Auth::user(), 6);

// CheckoutController uses PostageRateService
$historyRecord = $postageRateService->getCurrentHistory($region);
```

### 2.2 Business Logic in Models

Models contain domain logic beyond simple data mapping:

| Model | Business Logic |
|-------|----------------|
| **Coupon** | `isValidFor($user, $orderAmount)`, `calculateDiscount($amount)`, `scopeActive()` |
| **User** | `canReviewBook()`, `hasReviewedBook()`, `getProfileCompletionPercentage()` |
| **Book** | `getAverageRatingAttribute()`, `getFinalPriceAttribute()`, flash sale/discount accessors |
| **Order** | Status transitions, payment status |

### 2.3 Observers (`app/Observers/`)

| Observer | Purpose |
|----------|---------|
| **BookObserver** | Clear recommendation cache when books are created/updated/deleted |

### 2.4 Form Requests (`app/Http/Requests/`)

| Request | Validation Rules |
|---------|------------------|
| **ProfileUpdateRequest** | Name, email (unique), phone, address fields |
| **LoginRequest** | Email, password, rate limiting |

### 2.5 Exports (`app/Exports/`)

| Export | Purpose |
|--------|---------|
| **ProfitabilityReportExport** | Excel export for profitability reports |
| **SalesReportExport** | Excel export for sales and customer reports |

---

## 3. Data Access Layer

The Data Access Layer handles persistence, queries, and data retrieval.

### 3.1 Eloquent Models (`app/Models/`)

| Model | Table | Key Relationships |
|-------|-------|-------------------|
| **User** | users | orders, cart, reviews, wishlist |
| **Book** | books | genre, tropes, orderItems, reviews, cartItems |
| **Order** | orders | user, items, coupon |
| **OrderItem** | order_items | order, book |
| **Cart** | carts | user, items |
| **CartItem** | cart_items | cart, book |
| **Coupon** | coupons | usages |
| **CouponUsage** | coupon_usages | coupon, user, order |
| **FlashSale** | flash_sales | books (many-to-many via flash_sale_items) |
| **BookDiscount** | book_discounts | book |
| **Genre** | genres | books |
| **Trope** | tropes | books (many-to-many) |
| **Review** | reviews | user, book |
| **Wishlist** | wishlists | user, book |
| **PostageRate** | postage_rates | history |
| **PostageRateHistory** | postage_rate_history | postage_rate |
| **UserBookInteraction** | user_book_interactions | user, book |

### 3.2 Migrations (`database/migrations/`)

**Core Tables:**
- `users`, `books`, `genres`, `tropes`, `book_trope`
- `orders`, `order_items`, `carts`, `cart_items`
- `coupons`, `coupon_usages`, `flash_sales`, `flash_sale_items`, `book_discounts`
- `reviews`, `review_helpfuls`, `review_reports`, `wishlists`
- `postage_rates`, `postage_rate_history`
- `user_book_interactions`
- Spatie permission tables: `roles`, `permissions`, `model_has_roles`, etc.

### 3.3 Query Patterns

- **Eloquent ORM**: Primary data access mechanism
- **Query Builder**: Used for complex reports (e.g., `ReportsController`)
- **Eager Loading**: `with(['genre', 'tropes'])` to avoid N+1
- **Scopes**: `Coupon::active()`, `FlashSale::active()`
- **Cache**: RecommendationService caches results (30 min)

---

## 4. Cross-Layer Data Flow Example: Purchase Books

```
User (Browser)
    │
    ▼
[Route] POST /checkout
    │
    ▼
[Controller] CheckoutController::process()
    │
    ├─► [Request] Validate shipping info
    │
    ├─► [Service] PostageRateService::getCurrentHistory()  ──► [Model] PostageRate, PostageRateHistory
    │
    ├─► [Model] Coupon::isValidFor(), calculateDiscount()  ──► [Data] coupons, coupon_usages
    │
    ├─► [Model] Order::create(), OrderItem::create()        ──► [Data] orders, order_items
    │
    ├─► [Controller] createToyyibPayBill()                 ──► [External] ToyyibPay API
    │
    └─► [View] Redirect to payment URL
```

---

## 5. Summary Table

| Layer | Components | Location |
|-------|------------|----------|
| **User Interface** | Routes, Controllers, Views, API, Middleware | `routes/`, `app/Http/Controllers/`, `resources/views/` |
| **Domain** | Services, Model business logic, Observers, Form Requests, Exports | `app/Services/`, `app/Models/`, `app/Observers/`, `app/Http/Requests/`, `app/Exports/` |
| **Data Access** | Eloquent Models, Migrations, Cache | `app/Models/`, `database/migrations/` |

---

*This architecture follows a layered approach with clear separation of concerns. The User Interface layer handles presentation, the Domain layer encapsulates business logic, and the Data Access layer manages persistence.*
