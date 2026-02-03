# Chapter 4.6.2: Hybrid Recommendation System Implementation

This section documents the implementation of the Hybrid Recommendation System in the Bookty Enterprise e-commerce platform. The system is implemented in `App\Services\RecommendationService` and combines content-based filtering with collaborative filtering through a weighted fusion strategy. The hybrid scoring formula used is:

**FinalScore = (ContentScore × 0.6) + (CollaborativeScore × 0.4)**

Interaction weights used in building the user profile are defined in `UserBookInteraction::ACTION_WEIGHTS`: Purchase = 5.0, Cart = 4.0, Wishlist = 3.0, Click = 1.5, View = 1.0. Caching behaviour: if recommendations are cached for a user, the cached result is returned; otherwise, recommendations are generated, cached for 30 minutes, and returned.

---

## Table 4.6.1: Function-to-Subsection Mapping

| Function | Subsection | Called by Controllers? |
|----------|------------|-------------------------|
| `recommendForUser()` | 4.6.2.6 Hybrid Weighted Fusion Strategy | Yes (HomeController, RecommendationController, RecommendationAnalyticsController) |
| `similarToBook()` | 4.6.2.4 Content-Based Filtering Implementation | Yes (RecommendationController) |
| `generateSimilarBooks()` | 4.6.2.4 Content-Based Filtering Implementation | No (internal) |
| `generateRecommendations()` | 4.6.2.6 Hybrid Weighted Fusion Strategy | No (internal) |
| `contentBasedScores()` | 4.6.2.4 Content-Based Filtering Implementation | No (internal) |
| `collaborativeScores()` | 4.6.2.5 Collaborative Filtering Implementation | No (internal) |
| `fallbackRecommendations()` | 4.6.2.7 Cold Start Handling and Fallback Strategy | No (internal) |
| `generateSimilarBooks()` | 4.6.2.4 Content-Based Filtering Implementation | No (internal) |
| `getPurchasedBookIds()` | 4.6.2.4, 4.6.2.5 (helper) | No (internal) |
| `normalizeVector()` | 4.6.2.4, 4.6.2.5, 4.6.2.6 (helper) | No (internal) |

---

## 4.6.2.4 Content-Based Filtering Implementation

### Narrative

The content-based filtering component builds a user preference profile from multiple data sources: completed purchases, wishlist items, and implicit interactions (view, click, cart, wishlist). Each source is assigned a weight reflecting signal strength. The profile is expressed as genre, trope, and author weight vectors. Candidate books (not yet purchased, in stock) are scored by matching their features against this profile. Genre match contributes 1.0, trope overlap 0.6 per trope, author match 0.4, and a small popularity term 0.05 × review count. Scores are max-normalized to [0, 1] before fusion.

---

### Function: `contentBasedScores(User $user): array`

**Purpose:** Computes content-based similarity scores for candidate books by matching user preferences (genre, tropes, author) against book features.

**Input data and sources:**
- `User $user` — Target user (from controller).
- `order_items` + `orders` — Purchased book IDs via `getPurchasedBookIds()` (status = completed).
- `wishlists` — Wishlist book IDs via `User::wishlistBooks()`.
- `user_book_interactions` — Implicit feedback (view, click, cart, wishlist) with weight and count.
- `books`, `genres`, `book_trope`, `tropes` — Book metadata for profile construction and candidate scoring.

**Processing steps:**
1. Retrieve purchased book IDs, wishlist book IDs, and interaction records (grouped by book_id, aggregated as weight × count).
2. Merge all interest book IDs; if empty, return [] (cold-start handled elsewhere).
3. Load base books with genre and tropes; for each book, assign weight: purchase = 5.0, wishlist = 3.0, interactions = min(aggregated × 0.3, 2.0).
4. Accumulate genre, trope (×0.7), and author (×0.5) weights; normalize each vector via `normalizeVector()`.
5. Load candidate books (not purchased, stock > 0); for each, compute score from genre match (1.0), trope overlap (0.6), author match (0.4), and popularity (0.05 × reviews).
6. Return max-normalized scores as `[book_id => score]`.

**Output and usage:** Returns `array<int, float>` of book IDs to normalized scores. Used by `generateRecommendations()` for hybrid fusion.

**Insert Code Snippet 4.1 here** — `contentBasedScores()` method (lines 99–206 of RecommendationService.php).

---

### Function: `similarToBook(Book $book, int $limit = 8): Collection`

**Purpose:** Public entry point for item-to-item "Similar Books" recommendations. Handles caching and delegates to `generateSimilarBooks()` when cache misses.

**Input data and sources:**
- `Book $book` — Source book (from controller).
- `int $limit` — Maximum number of recommendations (default 8).
- Cache — Key `reco:similar:{book->id}:v1:{limit}`; tags `recommendations`, `book:{id}`.

**Processing steps:**
1. Build cache key `reco:similar:{book->id}:v1:{limit}`.
2. Attempt cache with tags; if unsupported, fall back to `Cache::remember()`.
3. If cache hit, return cached `Collection<Book>`.
4. If cache miss, call `generateSimilarBooks($book, $limit)` and cache for 30 minutes.
5. Return `Collection<Book>` with `score` attribute.

**Output and usage:** Returns `Collection<Book>`. Called by `RecommendationController::similarToBook()` for the "Similar Books" API. Results are serialized to JSON.

**Insert Code Snippet 4.2a here** — `similarToBook()` method (lines 259–275 of RecommendationService.php).

---

### Function: `generateSimilarBooks(Book $book, int $limit): Collection`

**Purpose:** Generates item-to-item recommendations for a given book using content-based similarity (genre, tropes, author). No user context required.

**Input data and sources:**
- `Book $book` — Source book (from controller).
- `books`, `genres`, `book_trope`, `tropes` — Candidate books with genre and tropes.

**Processing steps:**
1. Load candidate books (id ≠ source, stock > 0) with genre and tropes.
2. For each candidate: genre match = 1.0, trope overlap = 0.4 × count of shared tropes, author match = 0.3.
3. Normalize scores via `normalizeVector()`.
4. Fetch books by scored IDs, attach score, sort descending, take `$limit`.
5. Return `Collection<Book>`.

**Output and usage:** Returns `Collection<Book>` with `score` attribute. Used by `similarToBook()` after cache check. Consumed by `RecommendationController::similarToBook()` for the "Similar Books" API.

**Insert Code Snippet 4.2 here** — `generateSimilarBooks()` method (lines 281–318 of RecommendationService.php).

---

### Function: `getPurchasedBookIds(User $user): array`

**Purpose:** Retrieves the list of book IDs the user has purchased (completed orders). Used by both content-based and collaborative components.

**Input data and sources:**
- `User $user` — Target user.
- `order_items`, `orders` — Joined query where `orders.user_id = user.id` and `orders.status = 'completed'`.

**Processing steps:**
1. Join `order_items` with `orders`.
2. Filter by `orders.user_id` and `orders.status = 'completed'`.
3. Pluck `order_items.book_id`, unique, values, return as array.

**Output and usage:** Returns `int[]`. Used by `contentBasedScores()` and `collaborativeScores()`.

**Insert Code Snippet 4.3 here** — `getPurchasedBookIds()` method (lines 321–330 of RecommendationService.php).

---

### Function: `normalizeVector(array $vector): array`

**Purpose:** Normalizes associative array values to [0, 1] by dividing each value by the maximum. Ensures content and collaborative scores are on the same scale before fusion.

**Input data and sources:**
- `array $vector` — Associative array of keys to numeric values (e.g. `[book_id => score]`).

**Processing steps:**
1. If empty, return as-is.
2. Compute `max = max($vector)`; if max ≤ 0, return as-is.
3. For each entry, set `value = value / max`.
4. Return the modified array.

**Output and usage:** Returns normalized `array`. Used by `contentBasedScores()`, `collaborativeScores()`, and `generateSimilarBooks()`.

**Insert Code Snippet 4.4 here** — `normalizeVector()` method (lines 335–347 of RecommendationService.php).

---

## 4.6.2.5 Collaborative Filtering Implementation

### Narrative

The collaborative filtering component identifies peer users who have purchased at least one of the target user’s purchased books. It then scores books purchased by these peers but not by the target user, using co-purchase frequency as the score. Scores are max-normalized. The system limits to the top 200 books by frequency for performance. This component returns an empty array when the user has no purchase history.

---

### Function: `collaborativeScores(User $user): array`

**Purpose:** Computes collaborative scores based on co-purchase behaviour: books frequently bought by similar users (peers) receive higher scores.

**Input data and sources:**
- `User $user` — Target user.
- `order_items`, `orders` — Purchase history via `getPurchasedBookIds()` and peer/co-purchase queries.

**Processing steps:**
1. Get purchased book IDs; if empty, return [].
2. Find peer user IDs: users who bought any book in the user’s purchased set (excluding the user, completed orders only).
3. If no peers, return [].
4. Query books purchased by peers but not by the user: `group by book_id`, `count`, `order by count desc`, `limit 200`.
5. Build scores as `[book_id => count]`; normalize via `normalizeVector()`.
6. Return `[book_id => normalized_score]`.

**Output and usage:** Returns `array<int, float>`. Used by `generateRecommendations()` for hybrid fusion.

**Insert Code Snippet 4.5 here** — `collaborativeScores()` method (lines 213–255 of RecommendationService.php).

---

## 4.6.2.6 Hybrid Weighted Fusion Strategy

### Narrative

The hybrid fusion strategy combines content-based and collaborative scores using the formula **FinalScore = (ContentScore × 0.6) + (CollaborativeScore × 0.4)**. The public entry point is `recommendForUser()`, which checks the cache first. If cached results exist, they are returned; otherwise, `generateRecommendations()` is invoked. That method calls `contentBasedScores()` and `collaborativeScores()`, merges the score maps with the 0.6/0.4 weights, fetches books, attaches scores, sorts by score descending, and returns the top `$limit` items. Results are cached for 30 minutes.

---

### Function: `recommendForUser(User $user, int $limit = 12): Collection`

**Purpose:** Public entry point for personalized hybrid recommendations. Handles caching and delegates to `generateRecommendations()` when cache misses.

**Input data and sources:**
- `User $user` — Target user (from controller).
- `int $limit` — Maximum number of recommendations (default 12).
- Cache — Key `reco:user:{id}:v1:{limit}`; tags `recommendations`, `user:{id}`.

**Processing steps:**
1. Build cache key `reco:user:{user->id}:v1:{limit}`.
2. Attempt cache with tags; if tags unsupported, fall back to `Cache::remember()`.
3. If cache hit, return cached `Collection<Book>`.
4. If cache miss, call `generateRecommendations($user, $limit)` and cache result for 30 minutes.
5. Return `Collection<Book>` with `score` attribute.

**Output and usage:** Returns `Collection<Book>`. Called by `HomeController::index()` (limit 6), `RecommendationController::forUser()` (limit from request), and `RecommendationAnalyticsController::userDetails()` (limit 20). Results are passed to views or serialized to JSON.

**Insert Code Snippet 4.6 here** — `recommendForUser()` method (lines 18–34 of RecommendationService.php).

---

### Function: `generateRecommendations(User $user, int $limit): Collection`

**Purpose:** Orchestrates the hybrid recommendation pipeline: content-based scoring, collaborative scoring, weighted fusion, and book retrieval.

**Input data and sources:**
- `User $user` — Target user.
- `int $limit` — Maximum number of recommendations.
- Outputs of `contentBasedScores()` and `collaborativeScores()`.

**Processing steps:**
1. Call `contentBasedScores($user)` and `collaborativeScores($user)`.
2. If both empty (cold-start), call `fallbackRecommendations($limit)` and return.
3. Merge score maps: for each book, `finalScore = 0.6 × contentScore + 0.4 × collaborativeScore`.
4. If merged scores empty, call `fallbackRecommendations($limit)` and return.
5. Fetch books by scored IDs with genre and tropes; attach score, sort by score descending, take `$limit`.
6. Return `Collection<Book>`.

**Output and usage:** Returns `Collection<Book>`. Used internally by `recommendForUser()` when cache misses.

**Insert Code Snippet 4.7 here** — `generateRecommendations()` method (lines 39–75 of RecommendationService.php).

---

## 4.6.2.7 Cold Start Handling and Fallback Strategy

### Narrative

When a user has no purchase history and no interactions (view, click, cart, wishlist), both `contentBasedScores()` and `collaborativeScores()` return empty arrays. The system invokes `fallbackRecommendations()` to return popular books ordered by review count and recency. Each fallback book is assigned a default score of 1.0. This ensures that new or inactive users still receive recommendations.

---

### Function: `fallbackRecommendations(int $limit): Collection`

**Purpose:** Provides fallback recommendations for cold-start users (no purchases, no interactions) by returning popular books.

**Input data and sources:**
- `int $limit` — Maximum number of recommendations.
- `books` — Filtered by `stock > 0`, ordered by `reviews_count` desc, `created_at` desc.

**Processing steps:**
1. Query `Book` where `stock > 0`.
2. Order by `reviews_count` descending, then `created_at` descending.
3. Take `$limit`, load with genre and tropes.
4. Assign `score = 1.0` to each book.
5. Return `Collection<Book>`.

**Output and usage:** Returns `Collection<Book>`. Called by `generateRecommendations()` when content and collaborative scores are empty or when merged scores yield no books.

**Insert Code Snippet 4.8 here** — `fallbackRecommendations()` method (lines 81–93 of RecommendationService.php).

---

## 4.6.2.8 Benchmark and Effectiveness Monitoring

### Narrative

The `RecommendationService` does not contain dedicated benchmark or effectiveness functions. Effectiveness monitoring is performed by `RecommendationAnalyticsController`, which invokes `recommendForUser()` for user-level analysis and displays metrics such as genre match rate, trope match rate, co-purchase accuracy, precision, recall, and F1 score. The internal helpers `getPurchasedBookIds()` and `normalizeVector()` support the pipeline and could be instrumented for profiling if needed.

---

### Functions Supporting Monitoring

| Function | Role in Monitoring |
|----------|--------------------|
| `recommendForUser()` | Invoked by `RecommendationAnalyticsController::userDetails()` to generate recommendations for analysis. |
| `getPurchasedBookIds()` | Provides purchase data used in content-based and collaborative scoring; can be profiled for coverage metrics. |
| `normalizeVector()` | Ensures scores are on [0, 1]; used before fusion; can be profiled for distribution. |

**Insert Code Snippet 4.9 here** — Controller integration: `HomeController::index()` calling `recommendForUser()` (lines 163–170) and `RecommendationController::forUser()` (lines 20–30).

**Insert Code Snippet 4.10 here** — `RecommendationAnalyticsController::userDetails()` calling `recommendForUser()` (line 377).

---

## Controller Integration Summary

| Controller | Method | RecommendationService Method | Purpose |
|------------|--------|-------------------------------|---------|
| HomeController | index() | recommendForUser($user, 6) | Hero section recommendations |
| Api\RecommendationController | forUser() | recommendForUser($user, $limit) | API: GET /api/recommendations/me |
| Api\RecommendationController | similarToBook() | similarToBook($book, $limit) | API: GET /api/recommendations/similar/{book} |
| RecommendationAnalyticsController | userDetails() | recommendForUser($user, 20) | Admin user-level analysis |

---

## Data Tables Used (Implied)

| Table | Purpose |
|-------|---------|
| `users` | User accounts |
| `books` | Product catalog; genre_id, author, stock, reviews_count |
| `genres` | Book categories (one-to-many with books) |
| `tropes` | Thematic tags (many-to-many with books via book_trope) |
| `book_trope` | Pivot: books ↔ tropes |
| `orders` | Orders; user_id, status (completed) |
| `order_items` | Order line items; order_id, book_id |
| `wishlists` | User wishlist; user_id, book_id |
| `user_book_interactions` | Implicit feedback; user_id, book_id, action, weight, count |
