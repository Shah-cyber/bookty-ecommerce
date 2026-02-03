# Chapter 4: System Requirements, Design and Implementation

> **Author note:** Replace "Figure 4.x" with sequential numbers (4.1, 4.2, …) when inserting screenshots. Suggested figures: 4.1 Homepage "Recommended for You"; 4.2 System architecture; 4.3 ERD; 4.4 contentBasedScores() code; 4.5 Recommendation settings UI; 4.6 Cold-start flow; 4.7 Recommendation analytics dashboard. **Sequence diagram:** `diagrams/hybrid-recommendation-sequence.puml` (Hybrid Recommendation System sequence diagram).

---

This chapter presents the system requirements, architectural design, database schema, and implementation details of the Laravel-based e-commerce platform with a Hybrid Recommendation System. The content is structured into three main sections: Functional and Non-Functional System Requirements, System Architecture and Database Design, and System Development and Implementation.

---

## 4.1 Functional and Non-Functional System Requirements

### 4.1.1 Functional Requirements

The functional requirements define the capabilities the system must deliver. They are derived from the use cases and implemented through controllers, services, and views.

**Table 4.1: Functional Requirements by Module**

| ID | Requirement | Implementation |
|----|-------------|----------------|
| FR-01 | Users shall browse and search books by title, genre, and trope | `BookController@index`, filter logic |
| FR-02 | Users shall add books to cart and manage cart items | `CartController`, `CartItem` model |
| FR-03 | Users shall add books to wishlist and remove them | `WishlistController`, `Wishlist` model |
| FR-04 | Users shall complete checkout with coupon application and shipping calculation | `CheckoutController`, `PostageRateService` |
| FR-05 | Users shall view order history and download invoices | `ProfileController`, PDF generation |
| FR-06 | Users shall write reviews for purchased books | `ReviewController`, `Review` model |
| FR-07 | Users shall receive personalized book recommendations | `RecommendationService`, `recommendForUser()` |
| FR-08 | Users shall view books similar to a selected book | `RecommendationService`, `similarToBook()` |
| FR-09 | Admins shall manage books, genres, tropes, orders, coupons, discounts, and flash sales | Admin controllers, RBAC |
| FR-10 | Admins shall view reports (sales, customers, inventory, promotions, profitability) | `ReportsController` |
| FR-11 | Admins shall view recommendation analytics and adjust algorithm settings | `RecommendationAnalyticsController` |
| FR-12 | SuperAdmins shall manage roles, permissions, and system settings | SuperAdmin controllers, Spatie Permissions |

The recommendation module (FR-07, FR-08) is implemented as a service layer consumed by `HomeController`, `RecommendationController` (API), and `RecommendationAnalyticsController`. Figure 4.1 shows the homepage with the "Recommended for You" section populated by the hybrid algorithm.

### 4.1.2 Non-Functional Requirements

**Table 4.2: Non-Functional Requirements**

| ID | Category | Requirement |
|----|----------|-------------|
| NFR-01 | Performance | Recommendation responses shall be cached for 30 minutes to reduce database load |
| NFR-02 | Security | Access to admin and superadmin functions shall be restricted by role and permission |
| NFR-03 | Usability | The system shall support responsive layout for mobile and desktop |
| NFR-04 | Scalability | Database queries for recommendations shall limit result sets (e.g., top 200 collaborative candidates) |
| NFR-05 | Maintainability | Business logic shall be encapsulated in service classes (e.g., `RecommendationService`) |
| NFR-06 | Availability | Cold-start users shall receive fallback recommendations without errors |

---

## 4.2 System Architecture and Database Design

### 4.2.1 System Architecture

The system follows a layered architecture: Presentation (Blade views, JavaScript), Application (Controllers), Domain (Models), and Infrastructure (Services, Database). The `RecommendationService` resides in the application layer and is injected into controllers via Laravel's service container. Figure 4.2 illustrates the high-level architecture with the recommendation module integrated into the request flow.

### 4.2.2 Database Design

The database comprises 19 core entities. Key tables for the recommendation module are:

- **books**: Product catalog with `genre_id`, `author`, `stock`, `reviews_count`
- **genres**: Book categories (one-to-many with books)
- **tropes**: Thematic tags (many-to-many with books via `book_trope`)
- **order_items**: Purchase history (joined with `orders` for user and status)
- **wishlists**: User wishlist (user_id, book_id)
- **user_book_interactions**: Implicit feedback (user_id, book_id, action, weight, count)

**Table 4.3: user_book_interactions Schema (Recommendation Module)**

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key to users |
| book_id | bigint | Foreign key to books |
| action | varchar(20) | view, click, wishlist, cart, purchase |
| weight | decimal(3,1) | Action-specific weight |
| count | integer | Occurrence count |
| last_interacted_at | timestamp | Last interaction time |

The composite unique index `(user_id, book_id, action)` ensures one row per user-book-action combination. Figure 4.3 shows the entity-relationship diagram including the recommendation-related tables.

---

## 4.3 System Development and Implementation

### 4.3.1 Technology Stack

The system is built with Laravel (PHP), MySQL, Blade templating, Tailwind CSS, Vite, and Spatie Laravel Permission. The recommendation logic is implemented in PHP within the `App\Services\RecommendationService` class.

### 4.3.2 Hybrid Recommendation System Module

This section explains how the recommendation module was built and integrated. It covers the system requirement it fulfils, where it sits in the architecture, implementation details, formulas, benchmarks, and UI integration.

#### 4.3.2.1 System Requirement Fulfilled by the Recommendation Module

The recommendation module fulfils two functional requirements:

- **FR-07:** Users shall receive personalized book recommendations based on their behaviour.
- **FR-08:** Users shall view books similar to a selected book (item-to-item recommendations).

For FR-07, the system uses a hybrid approach: content-based scoring (user’s genres, tropes, authors) plus collaborative scoring (co-purchase patterns). For FR-08, only content-based similarity is used, since no user context is required. Figure 4.1 shows the homepage "Recommended for You" section populated by the hybrid algorithm.

#### 4.3.2.2 Architectural Placement of RecommendationService

`RecommendationService` is a service class in `App\Services\RecommendationService`. It lives in the application layer and is injected into controllers via Laravel’s dependency injection. Controllers do not contain recommendation logic; they only call the service and pass the result to the view or API response.

**Figure 4.2** shows the architectural placement: `HomeController`, `Api\RecommendationController`, and `RecommendationAnalyticsController` depend on `RecommendationService`, which in turn uses `Book`, `OrderItem`, `UserBookInteraction`, and `User` models. The service reads from `order_items`, `wishlists`, `user_book_interactions`, `books`, `genres`, and `book_trope` tables. The sequence diagram for the hybrid recommendation flow is provided in `diagrams/hybrid-recommendation-sequence.puml` (PlantUML) and `diagrams/hybrid-recommendation-sequence.mmd` (Mermaid), and may be inserted as Figure 4.x.

#### 4.3.2.3 Implementation Details

**Content-Based Filtering**

The `contentBasedScores()` method builds a user preference profile from purchased books, wishlist, and interactions (view, click, cart, wishlist). Each book in this interest set contributes to genre, trope, and author weights. The contribution depends on the action type. **Table 4.4** lists the interaction weights defined in `UserBookInteraction::ACTION_WEIGHTS`.

**Table 4.4: Interaction Weights**

| Action | Weight |
|--------|--------|
| view | 1.0 |
| click | 1.5 |
| wishlist | 3.0 |
| cart | 4.0 |
| purchase | 5.0 |

For implicit feedback (view, click, cart, wishlist), the aggregated weight is scaled by 0.3 and capped at 2.0 so it does not exceed wishlist strength.

For each candidate book (not purchased, in stock), the score is a weighted sum of genre match (1.0), trope overlap (0.6 per trope), author match (0.4), and a small popularity term (0.05 × review count). All content scores are max-normalized to \([0, 1]\) before fusion. **Figure 4.4** shows the `contentBasedScores()` method in the Laravel codebase.

**Collaborative Filtering**

The `collaborativeScores()` method finds users who bought at least one of the target user’s purchased books (peers). It then counts how many peers bought each book the user has not bought. That count is the raw collaborative score. Scores are max-normalized, and the system keeps only the top 200 books by frequency to limit query cost.

**Hybrid Fusion**

The `generateRecommendations()` method calls `contentBasedScores()` and `collaborativeScores()`. If both return empty arrays (cold-start), it falls back to popular books (by review count and recency). Otherwise, it merges the two score maps:

- For each book: `finalScore = 0.6 × contentScore + 0.4 × collaborativeScore`
- Books are sorted by `finalScore` descending and limited to the requested count.

The 0.6 / 0.4 split is configurable in the admin recommendation settings. **Figure 4.5** shows the settings screen. **Figure 4.6** illustrates the cold-start decision flow in the `generateRecommendations()` method.

#### 4.3.2.4 Mathematical Formulas

**Interaction weight aggregation.** For implicit feedback (view, click, cart, wishlist), the aggregated weight for a book is:

$$\text{AggWeight} = \sum (\text{actionWeight} \times \text{count})$$

This is scaled by 0.3 and capped at 2.0 so implicit signals stay below wishlist strength.

**Content-based score.** For a candidate book \(c\):

$$s_{\text{cb}}(c) = 1.0 \cdot W_g + 0.6 \cdot \sum W_t + 0.4 \cdot W_a + 0.05 \cdot \text{reviews}$$

where \(W_g\), \(W_t\), \(W_a\) are the normalized genre, trope, and author weights from the user profile. The implementation uses a weighted dot product between the user preference vector and the item feature vector. Conceptually, this is similar to cosine similarity:

$$\text{sim}(\mathbf{u}, \mathbf{i}) = \frac{\mathbf{u} \cdot \mathbf{i}}{\|\mathbf{u}\| \|\mathbf{i}\|}$$

The code uses max-normalization instead of cosine: \(\hat{s}_{\text{cb}} = s_{\text{cb}} / \max(s_{\text{cb}})\), giving scores in \([0, 1]\).

**Collaborative score.** For a book \(b\) not purchased by the user:

$$s_{\text{cf}}(b) = \text{count of peers who purchased } b$$

Again, \(\hat{s}_{\text{cf}} = s_{\text{cf}} / \max(s_{\text{cf}})\).

**Hybrid weighted score:**

$$s_{\text{hybrid}}(b) = 0.6 \cdot \hat{s}_{\text{cb}}(b) + 0.4 \cdot \hat{s}_{\text{cf}}(b)$$

#### 4.3.2.5 Benchmarks Used for Monitoring Effectiveness

The admin recommendation dashboard (`RecommendationAnalyticsController`) displays effectiveness metrics. These are used to monitor how well the module performs, not to run experiments.

**Table 4.5: Benchmarks for Recommendation Module**

| Metric | Component | Purpose |
|-------|-----------|---------|
| Genre match rate | Content-based | Share of recommendations matching user’s preferred genres |
| Trope match rate | Content-based | Share matching user’s preferred tropes |
| Author match rate | Content-based | Share matching user’s preferred authors |
| User similarity accuracy | Collaborative | Quality of peer identification |
| Co-purchase accuracy | Collaborative | Relevance of co-purchased items |
| Collaborative coverage | Collaborative | Share of users with collaborative data |
| Precision | Hybrid | Share of recommended items that were purchased |
| Recall | Hybrid | Share of purchased items that were recommended |
| F1 Score | Hybrid | Harmonic mean of precision and recall |

**Figure 4.7** shows the recommendation analytics dashboard with these metrics.

#### 4.3.2.6 UI Integration and System Outputs

**UI integration**

- **Homepage:** `HomeController` calls `recommendForUser($user, 6)` for the hero section. The "Recommended for You" grid loads via AJAX from `GET /api/recommendations/me?limit=12`.
- **Book detail page:** "Similar Books" loads via `GET /api/recommendations/similar/{book}?limit=8`, which uses `similarToBook()` (content-based only).
- **Admin:** Recommendation analytics at `/admin/recommendations` and settings at `/admin/recommendations/settings`.

**System outputs**

- **Primary output:** A collection of `Book` models with a `score` attribute, sorted by score descending, limited to the requested count.
- **Caching:** Results cached under `reco:user:{userId}:v1:{limit}` for 30 minutes to reduce database load.
- **API response:** JSON with book data (id, title, author, price, cover, score, link) for the frontend to render.

User interactions (view, click, cart, wishlist) are sent to `POST /api/track-interaction` and stored in `user_book_interactions`. The frontend calls this endpoint when the user performs these actions so the content-based profile stays up to date.

---

## Summary

This chapter presented the system requirements, architecture, database design, and implementation of the Laravel e-commerce platform. The Hybrid Recommendation System is implemented as a module in `RecommendationService`. It fulfils FR-07 (personalized recommendations) and FR-08 (similar books). The module combines content-based scoring (genre, trope, author) with collaborative co-purchase scoring, uses interaction weights for preference modelling, and falls back to popular books for cold-start users. It is integrated via `HomeController`, `RecommendationController`, and `RecommendationAnalyticsController`, with benchmarks and settings managed in the admin interface.
