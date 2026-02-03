# Chapter 4: System Design and Implementation

> **Note for authors:** Replace `4.X` with your actual section number (e.g., 4.3, 4.4). Replace "Figure 4.X" with sequential figure numbers (e.g., Figure 4.1, 4.2) when inserting screenshots of Laravel code and UI.

---

## 4.X Hybrid Recommendation Service Implementation

This section describes the implementation of the Hybrid Recommendation System within the Laravel-based e-commerce platform. The system combines Content-Based Filtering (CBF) and Collaborative Filtering (CF) through a weighted fusion strategy to deliver personalized book recommendations. The implementation is encapsulated in the `RecommendationService` class, which exposes methods such as `recommendForUser()`, `contentBasedScores()`, and `collaborativeScores()`.

---

### 4.X.1 Architecture Overview

The recommendation pipeline consists of three main stages: (1) content-based scoring, (2) collaborative scoring, and (3) hybrid weighted fusion. A cold-start fallback mechanism ensures that users with no interaction history still receive relevant recommendations. Figure 4.X illustrates the high-level flow of the recommendation generation process.

**Algorithm 4.1** presents the main recommendation logic implemented in `recommendForUser()`:

```
Algorithm 4.1: recommendForUser(user, limit)
────────────────────────────────────────────────────────────────
Input:  user – the target user; limit – maximum number of recommendations
Output: Collection of books ranked by hybrid score

1.  contentScores ← contentBasedScores(user)
2.  collabScores  ← collaborativeScores(user)
3.  if contentScores = ∅ AND collabScores = ∅ then
4.      return fallbackRecommendations(limit)    // Cold-start
5.  scores ← ∅
6.  for each (bookId, score) in contentScores do
7.      scores[bookId] ← scores[bookId] + (0.6 × score)
8.  for each (bookId, score) in collabScores do
9.      scores[bookId] ← scores[bookId] + (0.4 × score)
10. books ← fetch books by ids, attach scores, sort descending
11. return books.take(limit)
────────────────────────────────────────────────────────────────
```

---

### 4.X.2 Content-Based Filtering

Content-based filtering builds a user preference profile from their interaction history and matches candidate items by feature similarity. The system uses three item attributes: **genre**, **tropes** (thematic tags), and **author**. The `contentBasedScores()` method implements this logic.

#### 4.X.2.1 User Preference Profile Construction

The user profile is derived from multiple interaction sources, each assigned a **signal strength weight** to reflect intent. Table 4.1 defines the interaction weights used in the system.

**Table 4.1: Interaction Weights by Action Type**

| Action   | Weight | Rationale                                      |
|----------|--------|------------------------------------------------|
| View     | 1.0    | Weak signal; user browsed the item             |
| Click    | 1.5    | Moderate signal; explicit engagement          |
| Wishlist | 3.0    | Strong signal; explicit interest               |
| Cart     | 4.0    | Very strong signal; purchase intent            |
| Purchase | 5.0    | Strongest signal; confirmed preference         |

These weights are defined in the `UserBookInteraction` model as `ACTION_WEIGHTS`. For implicit feedback (view, click, cart), the aggregated contribution for a book is computed as:

$$
\text{AggregatedWeight}(b) = \sum_{a \in \text{actions}} w_a \times c_a
$$

where \( w_a \) is the weight for action \( a \) and \( c_a \) is the count of that action for book \( b \). This value is then capped and scaled (e.g., \(\min(\text{AggregatedWeight} \times 0.3, 2.0)\)) so that implicit signals do not dominate explicit ones such as wishlist and purchase.

#### 4.X.2.2 Feature Weight Accumulation

For each book in the user’s interest set (purchased, wishlisted, or interacted), the system accumulates weights into genre, trope, and author vectors:

$$
W_g(g) = \sum_{b \in B_u \mid \text{genre}(b)=g} \omega_b
$$

$$
W_t(t) = \sum_{b \in B_u \mid t \in \text{tropes}(b)} 0.7 \times \omega_b
$$

$$
W_a(a) = \sum_{b \in B_u \mid \text{author}(b)=a} 0.5 \times \omega_b
$$

where \( B_u \) is the set of books the user has interacted with, \( \omega_b \) is the weight assigned to book \( b \) (from Table 4.1 or aggregated implicit weight), and \( g \), \( t \), and \( a \) denote genre, trope, and author respectively. The coefficients 0.7 and 0.5 reflect the relative importance of tropes and author compared to genre.

#### 4.X.2.3 Similarity Scoring and Normalization

For each candidate book \( c \) (not yet purchased), the content-based score is computed as a weighted sum of feature matches:

$$
s_{\text{cb}}(c) = \alpha_g \cdot W_g(\text{genre}(c)) + \alpha_t \cdot \sum_{t \in \text{tropes}(c)} W_t(t) + \alpha_a \cdot W_a(\text{author}(c)) + \beta \cdot \text{popularity}(c)
$$

where \( \alpha_g = 1.0 \), \( \alpha_t = 0.6 \), \( \alpha_a = 0.4 \), and \( \beta = 0.05 \) for a light popularity boost based on review count. The resulting scores are normalized to \([0, 1]\) by max-normalization:

$$
\hat{s}_{\text{cb}}(c) = \frac{s_{\text{cb}}(c)}{\max_{c'} s_{\text{cb}}(c')}
$$

Conceptually, this resembles a cosine-like similarity between the user’s preference vector and the item’s feature vector, with feature-specific weights. Figure 4.X shows the structure of the `contentBasedScores()` method in the Laravel codebase.

**Algorithm 4.2** summarises the content-based scoring procedure:

```
Algorithm 4.2: contentBasedScores(user)
────────────────────────────────────────────────────────────────
Input:  user – the target user
Output: Map of book_id → normalized score [0, 1]

1.  B_u ← purchased books ∪ wishlist books ∪ interacted books
2.  if B_u = ∅ then return ∅
3.  Initialize genreWeights, tropeWeights, authorWeights
4.  for each book b in B_u do
5.      ω ← weight from purchase/wishlist/interaction
6.      if b.genre then genreWeights[b.genre] += ω
7.      for each trope t in b.tropes do tropeWeights[t] += 0.7 × ω
8.      if b.author then authorWeights[b.author] += 0.5 × ω
9.  Normalize genreWeights, tropeWeights, authorWeights by max
10. candidates ← books not in purchased, stock > 0
11. for each candidate c do
12.     score ← genreMatch + tropeOverlap + authorMatch + 0.05×popularity
13.     if score > 0 then scores[c.id] ← score
14. return normalizeVector(scores)
────────────────────────────────────────────────────────────────
```

---

### 4.X.3 Collaborative Filtering

Collaborative filtering exploits co-purchase behaviour: users who bought similar items are treated as peers, and items frequently bought by peers are recommended. The `collaborativeScores()` method implements this user-based, co-purchase approach.

#### 4.X.3.1 Peer Identification

Let \( P_u \) be the set of books purchased by user \( u \). The peer set \( \mathcal{N}_u \) consists of users who have purchased at least one book in \( P_u \):

$$
\mathcal{N}_u = \{ v \mid v \neq u \land P_v \cap P_u \neq \emptyset \}
$$

Only completed orders are considered. This is implemented via a join between `order_items` and `orders` with `status = 'completed'`.

#### 4.X.3.2 Co-Purchase Score

For each book \( b \) not in \( P_u \), the collaborative score is the number of peers who purchased \( b \):

$$
s_{\text{cf}}(b) = |\{ v \in \mathcal{N}_u \mid b \in P_v \}|
$$

The system limits the candidate set (e.g., top 200 by frequency) for performance. Scores are then max-normalized:

$$
\hat{s}_{\text{cf}}(b) = \frac{s_{\text{cf}}(b)}{\max_{b'} s_{\text{cf}}(b')}
$$

This frequency-based score approximates item popularity among similar users. Figure 4.X shows the SQL-like logic used to compute peer purchases in the Laravel implementation.

**Algorithm 4.3** describes the collaborative scoring procedure:

```
Algorithm 4.3: collaborativeScores(user)
────────────────────────────────────────────────────────────────
Input:  user – the target user
Output: Map of book_id → normalized score [0, 1]

1.  P_u ← getPurchasedBookIds(user)
2.  if P_u = ∅ then return ∅
3.  N_u ← users who purchased any book in P_u (exclude user)
4.  if N_u = ∅ then return ∅
5.  for each book b purchased by users in N_u, b ∉ P_u do
6.      scores[b] ← count of peers who purchased b
7.  Limit to top 200 books by score
8.  return normalizeVector(scores)
────────────────────────────────────────────────────────────────
```

---

### 4.X.4 Hybrid Weighted Fusion

The final recommendation score combines content-based and collaborative scores using a weighted linear combination:

$$
s_{\text{hybrid}}(b) = \lambda \cdot \hat{s}_{\text{cb}}(b) + (1 - \lambda) \cdot \hat{s}_{\text{cf}}(b)
$$

where \( \lambda = 0.6 \) (content-based) and \( (1 - \lambda) = 0.4 \) (collaborative). These weights favour content-based signals to improve relevance when user data is sparse, while still incorporating community behaviour. The weights are configurable via the admin settings interface; Figure 4.X shows the recommendation settings screen where these values can be adjusted.

Books are ranked by \( s_{\text{hybrid}}(b) \) in descending order, and the top \( k \) items are returned. The fusion logic is implemented in `generateRecommendations()`, which is invoked by `recommendForUser()`.

---

### 4.X.5 Cold-Start Handling and Fallback Recommendations

Two cold-start scenarios are handled:

1. **New users** with no purchases, wishlist entries, or interactions.
2. **Users with data** but no overlapping candidate set after fusion.

In both cases, `contentBasedScores()` and `collaborativeScores()` return empty sets. The system then invokes `fallbackRecommendations(limit)`, which returns a popularity-based list:

$$
\text{Fallback}(k) = \text{Top}_k \left( \text{Books} \mid \text{stock} > 0 \right) \text{ ordered by } (\text{reviews\_count} \downarrow, \text{created\_at} \downarrow)
$$

Books are ranked by review count (as a proxy for popularity) and recency. Each fallback item is assigned a default score of 1.0 for consistency with the recommendation API. Figure 4.X illustrates the cold-start decision flow.

**Algorithm 4.4** summarises the fallback logic:

```
Algorithm 4.4: fallbackRecommendations(limit)
────────────────────────────────────────────────────────────────
Input:  limit – maximum number of recommendations
Output: Collection of popular books

1.  return Book.where(stock > 0)
2.           .orderBy(reviews_count, DESC)
3.           .orderBy(created_at, DESC)
4.           .take(limit)
5.           .each(book → book.score = 1.0)
────────────────────────────────────────────────────────────────
```

---

### 4.X.6 Caching and Performance

To reduce computational cost, recommendations are cached per user. The cache key follows the pattern `reco:user:{userId}:v1:{limit}` with a 30-minute TTL. Cache tags (`recommendations`, `user:{id}`) support targeted invalidation when user behaviour changes. If the cache driver does not support tags, a fallback to standard `Cache::remember()` is used.

---

### 4.X.7 Integration Points

The `RecommendationService` is injected into `HomeController` and `RecommendationController`. On the homepage, authenticated users receive hybrid recommendations via `recommendForUser()` (e.g., 6 items for the hero section). The API endpoint `GET /api/recommendations/me?limit=12` serves personalized recommendations for AJAX-loaded sections. Figure 4.X shows the "Recommended for You" section on the homepage.

A separate method, `similarToBook(book, limit)`, provides content-based "Similar Books" recommendations on the book detail page, using only genre, trope, and author overlap—no user data is required. This supports both cold-start and item-to-item discovery.

---

### 4.X.8 Summary

The Hybrid Recommendation Service combines content-based and collaborative filtering through a configurable weighted fusion. Content-based scoring uses interaction-weighted user profiles (genre, tropes, author) with max-normalization. Collaborative scoring uses co-purchase frequency among peer users. Cold-start is addressed via a popularity-based fallback. The implementation is modular, cacheable, and integrated into the Laravel e-commerce platform through the `RecommendationService` class and its public methods `recommendForUser()`, `contentBasedScores()`, and `collaborativeScores()`.
