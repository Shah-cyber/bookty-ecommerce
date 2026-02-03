# Chapter 4.6.2: Hybrid Recommendation System — Mathematics and Evaluation Metrics

This subsection documents the mathematical foundations and evaluation metrics used in the Hybrid Recommendation System implemented in `App\Services\RecommendationService`. The content is organised by component: content-based filtering, collaborative filtering, hybrid fusion, normalization, and benchmark metrics.

---

## 4.6.2.4 Content-Based Filtering Implementation

### A) Content-Based Filtering Mathematics

#### 1. Feature Vector Representation for a Book

Each book $b$ is represented by a feature vector derived from metadata. The system uses three feature types: genre, tropes (thematic tags), and author. Let $\mathbf{f}_b$ denote the feature vector for book $b$:

- **Genre:** One-hot or categorical; book $b$ belongs to genre $g(b)$.
- **Tropes:** Multi-valued; book $b$ has tropes $T_b = \{t_1, t_2, \ldots, t_k\}$.
- **Author:** Categorical; book $b$ has author $a(b)$.

In the implementation, a candidate book $c$ is scored by matching its genre, tropes, and author against the user's preference weights. The raw score is a weighted sum:

$$s_{cb}(c) = \alpha_g \cdot W_g(g(c)) + \alpha_t \cdot \sum_{t \in T_c} W_t(t) + \alpha_a \cdot W_a(a(c)) + \beta \cdot \text{popularity}(c)$$

where $\alpha_g = 1.0$, $\alpha_t = 0.6$, $\alpha_a = 0.4$, $\beta = 0.05$, and $W_g$, $W_t$, $W_a$ are the user's normalized genre, trope, and author preference weights.

**Insert Table 4.1 Feature Coefficients here**

| Feature | Coefficient | Purpose |
|---------|-------------|---------|
| Genre match | $\alpha_g = 1.0$ | Primary category signal |
| Trope overlap | $\alpha_t = 0.6$ per trope | Thematic similarity |
| Author match | $\alpha_a = 0.4$ | Author affinity |
| Popularity | $\beta = 0.05$ | Light boost from review count |

---

#### 2. User Preference Vector Construction Using Weighted Interactions

The user preference profile is built from weighted interactions. Each interaction type is assigned a weight reflecting signal strength:

**Insert Table 4.2 Interaction Weights here**

| Action | Weight $w_a$ | Rationale |
|--------|---------------|-----------|
| Purchase | 5 | Strongest signal; confirmed preference |
| Add to cart | 3 | Strong purchase intent |
| Add to wishlist | 2 | Explicit interest |
| View details | 1 | Weakest signal; passive browsing |

For each book $b$ in the user's interest set (purchased, wishlisted, or interacted), a weight $\omega_b$ is assigned: $\omega_b = w_a$ for purchase, cart, wishlist, or view. For implicit feedback (view, click, cart, wishlist), the aggregated weight is $\sum_a (w_a \times c_a)$ where $c_a$ is the count of action $a$; this value is scaled and capped (e.g. $\min(\text{aggregated} \times 0.3, 2.0)$) so implicit signals do not exceed wishlist strength.

The user preference vectors $W_g$, $W_t$, and $W_a$ are accumulated as follows:

$$W_g(g) = \sum_{b \in B_u \mid g(b)=g} \omega_b, \quad W_t(t) = \sum_{b \in B_u \mid t \in T_b} 0.7 \cdot \omega_b, \quad W_a(a) = \sum_{b \in B_u \mid a(b)=a} 0.5 \cdot \omega_b$$

where $B_u$ is the set of books the user has interacted with. Each vector is then max-normalized to $[0, 1]$.

---

#### 3. Cosine Similarity Formula

The similarity between the user preference vector $\mathbf{u}$ and the item feature vector $\mathbf{i}$ is computed using cosine similarity:

**Insert Equation 4.1 Cosine Similarity here**

$$\text{sim}(\mathbf{u}, \mathbf{i}) = \frac{\mathbf{u} \cdot \mathbf{i}}{\|\mathbf{u}\| \|\mathbf{i}\|} = \frac{\sum_k u_k \cdot i_k}{\sqrt{\sum_k u_k^2} \cdot \sqrt{\sum_k i_k^2}}$$

where $\mathbf{u} \cdot \mathbf{i}$ is the dot product and $\|\mathbf{u}\|$, $\|\mathbf{i}\|$ are the Euclidean norms. The result lies in $[-1, 1]$ for real-valued vectors; for non-negative weights it lies in $[0, 1]$.

---

#### 4. From Similarity to ContentScore

The implementation uses a weighted dot product between the user preference vector and the item feature vector, which is conceptually equivalent to an unnormalized cosine similarity. The raw score $s_{cb}(c)$ is computed as the weighted sum of genre match, trope overlap, author match, and popularity. This raw score is then max-normalized:

$$\hat{s}_{cb}(c) = \frac{s_{cb}(c)}{\max_{c'} s_{cb}(c')}$$

The normalized value $\hat{s}_{cb}(c)$ becomes the **ContentScore** for book $c$, in the range $[0, 1]$. Books with higher ContentScore are more similar to the user's preferences and rank higher in content-based recommendations.

The content-based component produces a ContentScore for each candidate book. The following subsection describes how the collaborative component produces a CollaborativeScore from co-purchase behaviour.

---

## 4.6.2.5 Collaborative Filtering Implementation

### B) Collaborative Filtering Mathematics

#### 1. Co-Purchase and Peer Similarity

Peer similarity is based on co-purchase behaviour. Let $P_u$ be the set of books purchased by user $u$. The peer set $\mathcal{N}_u$ consists of users who have purchased at least one book in $P_u$:

$$\mathcal{N}_u = \{v \mid v \neq u \land P_v \cap P_u \neq \emptyset\}$$

Users in $\mathcal{N}_u$ are treated as similar to $u$ because they share purchase history. Only completed orders are considered.

---

#### 2. Item-Based Co-Occurrence Scoring

For each book $b$ not in $P_u$, the collaborative score is the number of peers who purchased $b$:

**Insert Equation 4.2 Co-Purchase Score here**

$$s_{cf}(b) = \bigl|\{v \in \mathcal{N}_u \mid b \in P_v\}\bigr|$$

That is, $s_{cf}(b)$ is the co-purchase frequency: how many similar users bought book $b$. The system limits to the top 200 books by $s_{cf}(b)$ for performance.

---

#### 3. From Co-Occurrence to CollaborativeScore

The raw co-purchase count $s_{cf}(b)$ is max-normalized to obtain the **CollaborativeScore**:

$$\hat{s}_{cf}(b) = \frac{s_{cf}(b)}{\max_{b'} s_{cf}(b')}$$

The normalized value $\hat{s}_{cf}(b)$ lies in $[0, 1]$. Books frequently purchased by similar users receive higher CollaborativeScore and are ranked higher in collaborative recommendations.

The collaborative component produces a CollaborativeScore for each candidate book. The following subsection describes how the two scores are combined into a final recommendation score.

---

## 4.6.2.6 Hybrid Weighted Fusion Strategy

### C) Hybrid Weighted Fusion

#### 1. Final Fusion Equation

The content-based and collaborative scores are combined using a weighted linear combination:

**Insert Equation 4.3 Hybrid Fusion here**

$$\text{FinalScore}(b) = 0.6 \times \hat{s}_{cb}(b) + 0.4 \times \hat{s}_{cf}(b)$$

where $\hat{s}_{cb}(b)$ is the ContentScore and $\hat{s}_{cf}(b)$ is the CollaborativeScore for book $b$. The weights 0.6 and 0.4 sum to 1.0 and are configurable via the admin recommendation settings.

---

#### 2. Rationale for Weighting

Weighting is used for three reasons. First, content-based and collaborative scores are on different scales before normalization; weighting after normalization allows a controlled blend. Second, content-based filtering (0.6) is favoured because it works with sparse data and cold-start users who have few or no purchases. Third, collaborative filtering (0.4) adds community-based signals when purchase data exists. The 0.6/0.4 split balances personalisation from item features with discovery from peer behaviour. Weighted fusion helps when data is sparse or cold-start, as content-based scores can still be computed from views, wishlist, and cart, while collaborative scores may be empty (Zhang et al., 2020).

---

#### 3. Citation

Weighted linear combination of content-based and collaborative scores is a standard hybrid fusion strategy that mitigates cold-start and sparsity (Zhang et al., 2020).

---

## Normalization

Before fusion, both content-based and collaborative scores are normalized. The following subsection explains why normalization is required and how it is implemented.

### D) Normalization

#### 1. Why Normalization Is Required

Content-based and collaborative scores are produced by different processes and can have different ranges. Content-based scores come from a weighted sum of feature matches; collaborative scores come from co-purchase counts. Without normalization, one component could dominate the fusion. Normalizing both to $[0, 1]$ ensures they contribute proportionally to the final score.

---

#### 2. Max-Normalization Expression

The implementation uses max-normalization (divide by maximum):

**Insert Equation 4.4 Max-Normalization here**

$$\hat{v}_k = \frac{v_k}{\max_j v_j}$$

For an associative array $\mathbf{v} = \{k \mapsto v_k\}$, each value is divided by $\max(\mathbf{v})$. If $\max \leq 0$ or the array is empty, the vector is returned unchanged.

---

#### 3. The normalizeVector Function

The `normalizeVector(array $vector): array` function implements max-normalization:

1. If the array is empty, return it unchanged.
2. Compute $m = \max(\text{values})$.
3. If $m \leq 0$, return the array unchanged.
4. For each key $k$, set $\text{vector}[k] = \text{vector}[k] / m$.
5. Return the modified array.

The function is used by `contentBasedScores()`, `collaborativeScores()`, and `generateSimilarBooks()` to ensure all scores lie in $[0, 1]$ before fusion or output.

**Insert Code Snippet 4.11 here** — `normalizeVector()` method (RecommendationService.php, lines 335–347).

---

## 4.6.2.8 Benchmark and Effectiveness Monitoring

The system monitors recommendation effectiveness using precision, recall, and F1 score. The following subsection defines these metrics formally and explains their use in the system context.

### E) Benchmark and Monitoring Metrics

#### 1. Formal Definitions

**Precision** is the fraction of recommended items that were relevant (e.g. purchased):

**Insert Equation 4.5 Precision here**

$$\text{Precision} = \frac{TP}{TP + FP}$$

where $TP$ is the number of recommended items that were purchased, and $FP$ is the number of recommended items that were not purchased.

**Recall** is the fraction of relevant items that were recommended:

**Insert Equation 4.6 Recall here**

$$\text{Recall} = \frac{TP}{TP + FN}$$

where $FN$ is the number of purchased items that were not recommended.

**F1 Score** is the harmonic mean of precision and recall:

**Insert Equation 4.7 F1 Score here**

$$F1 = 2 \times \frac{\text{Precision} \times \text{Recall}}{\text{Precision} + \text{Recall}}$$

---

#### 2. Use as Monitoring Indicators

In the system context, these metrics are used by `RecommendationAnalyticsController` to monitor effectiveness:

- **Precision** indicates how often recommendations lead to purchases; higher precision means fewer irrelevant suggestions.
- **Recall** indicates how well the system surfaces items the user eventually buys; higher recall means fewer missed relevant items.
- **F1 Score** balances precision and recall; it is used as a single summary metric for algorithm tuning and comparison.

The admin recommendation dashboard displays these metrics alongside genre match rate, trope match rate, co-purchase accuracy, and collaborative coverage. They support monitoring rather than formal experimentation.

---

#### 3. Example Calculation

**Insert Table 4.3 Example Metric Calculation here**

Suppose for a user the system recommended 10 books, and the user purchased 4 of them. Of all books the user purchased in the period, 6 were recommended.

- $TP = 4$ (recommended and purchased)
- $FP = 6$ (recommended but not purchased)
- $FN = 2$ (purchased but not recommended)

Then:

$$\text{Precision} = \frac{4}{4 + 6} = \frac{4}{10} = 0.40$$

$$\text{Recall} = \frac{4}{4 + 2} = \frac{4}{6} \approx 0.67$$

$$F1 = 2 \times \frac{0.40 \times 0.67}{0.40 + 0.67} = 2 \times \frac{0.268}{1.07} \approx 0.50$$

This example illustrates how precision, recall, and F1 are computed from recommendation and purchase data for monitoring purposes.
