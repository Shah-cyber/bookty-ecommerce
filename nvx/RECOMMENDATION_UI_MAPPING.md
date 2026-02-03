# Recommendation Functions - UI Location Mapping

## 📍 Overview

This document maps each recommendation location in your UI to the specific function used from `RecommendationService`.

---

## 🎯 **Three Main Functions in RecommendationService**

### 1. `recommendForUser(User $user, int $limit = 12)` - HYBRID
**Algorithm:** Content-Based (60%) + Collaborative Filtering (40%)

```php
// Location: app/Services/RecommendationService.php (Line 18)
public function recommendForUser(User $user, int $limit = 12): Collection
{
    $contentScores = $this->contentBasedScores($user);      // 60% weight
    $collabScores = $this->collaborativeScores($user);      // 40% weight
    
    // Fusion formula
    $finalScore = ($contentScore × 0.6) + ($collabScore × 0.4);
    
    return $books->sortByDesc('score')->take($limit);
}
```

**What it does:**
- Uses user's purchase history, wishlist, and interactions
- Finds similar users and their purchases
- Combines both approaches for best results

---

### 2. `similarToBook(Book $book, int $limit = 8)` - CONTENT-BASED ONLY
**Algorithm:** Content-Based Filtering (100%)

```php
// Location: app/Services/RecommendationService.php (Line 257)
public function similarToBook(Book $book, int $limit = 8): Collection
{
    // Find books with:
    // - Same genre (weight: 1.0)
    // - Shared tropes (weight: 0.4 per trope)
    // - Same author (weight: 0.3)
    
    $score = $genreMatch + $tropeOverlaps + $authorMatch;
    
    return $books->sortByDesc('score')->take($limit);
}
```

**What it does:**
- Compares book features (genre, tropes, author)
- No user data needed
- Pure item-to-item similarity

---

### 3. `fallbackRecommendations(int $limit)` - POPULARITY-BASED
**Algorithm:** Trending/Popular Books

```php
// Location: app/Services/RecommendationService.php (Line 81)
protected function fallbackRecommendations(int $limit): Collection
{
    return Book::where('stock', '>', 0)
        ->orderByDesc('reviews_count')
        ->orderByDesc('created_at')
        ->take($limit)
        ->get();
}
```

**What it does:**
- Shows popular books (by review count)
- Used when user has no data at all (cold-start)

---

## 🗺️ **UI Location to Function Mapping**

### **Location 1: Homepage - "Recommended for You"**

**Function Used:** `recommendForUser()` - **HYBRID** (Content 60% + Collaborative 40%)

#### Implementation Details:

**Backend (Server-side initial load):**
```php
// File: app/Http/Controllers/HomeController.php (Line 54)
if (Auth::check()) {
    $recommendations = $this->recommendationService->recommendForUser(Auth::user(), 6);
}
```

**Frontend (AJAX load):**
```javascript
// File: resources/views/home/index.blade.php (Line 804)
window.RecommendationManager.loadRecommendations('recommendations-grid', 12);
```

**API Endpoint:**
```
GET /api/recommendations/me?limit=12
↓
RecommendationController@forUser (Line 20)
↓
$this->service->recommendForUser($user, $limit)
```

**API Route:**
```php
// File: routes/web.php or api.php
Route::get('/api/recommendations/me', [RecommendationController::class, 'forUser'])
    ->middleware('auth');
```

#### Why Hybrid Here?
✅ **Best personalization** - Combines user's preferences with community patterns  
✅ **Most comprehensive** - Uses all available data  
✅ **Homepage goal** - Show the BEST recommendations to keep user engaged

---

### **Location 2: Book Detail Page - "Similar Books"**

**Function Used:** `similarToBook()` - **CONTENT-BASED ONLY**

#### Implementation Details:

**Frontend (AJAX load):**
```javascript
// File: resources/views/books/show.blade.php (Line 1290)
window.RecommendationManager.loadSimilarBooks({{ $book->id }}, 'similar-books-list', 6);
```

**JavaScript Function:**
```javascript
// File: resources/js/app.js (Line 319)
async fetchSimilarBooks(bookId, limit = 8) {
    const response = await fetch(`/api/recommendations/similar/${bookId}?limit=${limit}`);
    return response.json();
}
```

**API Endpoint:**
```
GET /api/recommendations/similar/{book}?limit=6
↓
RecommendationController@similarToBook (Line 36)
↓
$this->service->similarToBook($book, $limit)
```

**API Route:**
```php
// File: routes/web.php or api.php
Route::get('/api/recommendations/similar/{book}', [RecommendationController::class, 'similarToBook']);
```

#### Why Content-Based Only Here?
✅ **Book-focused** - User is viewing THIS specific book  
✅ **Context-relevant** - Show books similar to current one  
✅ **No user data needed** - Works for guest users too  
✅ **Faster** - No need to analyze user history or find similar users

#### Algorithm Breakdown:
```php
// For book: "Harry Potter and the Philosopher's Stone"
// Genre: Fantasy, Tropes: ["Magic School", "Chosen One"], Author: "J.K. Rowling"

Candidate: "Percy Jackson and the Lightning Thief"
├─ Same genre (Fantasy) → +1.0
├─ Shared trope ("Chosen One") → +0.4
├─ Different author → +0.0
└─ Score: 1.4

Candidate: "Harry Potter and the Chamber of Secrets"
├─ Same genre (Fantasy) → +1.0
├─ Shared tropes ("Magic School", "Chosen One") → +0.8
├─ Same author (J.K. Rowling) → +0.3
└─ Score: 2.1 (HIGHEST - Shows first!)
```

---

### **Location 3: Cart/Checkout Page - "You Might Also Like"**

**Function Used:** `recommendForUser()` - **HYBRID** (Content 60% + Collaborative 40%)

#### Implementation Details:

**Frontend (AJAX load):**
```javascript
// File: resources/views/cart/index.blade.php (Line 182)
window.RecommendationManager.loadRecommendations('cart-recommendations-grid', 8);
```

**API Endpoint:**
```
GET /api/recommendations/me?limit=8
↓
RecommendationController@forUser (Line 20)
↓
$this->service->recommendForUser($user, $limit)
```

#### Why Hybrid Here?
✅ **Cross-sell opportunity** - Show books user is likely to buy  
✅ **Personalized** - Based on user's full profile + cart items  
✅ **Conversion-focused** - Best recommendations to increase cart value  
✅ **Uses cart data** - Cart interactions are tracked and weighted (4.0)

#### How Cart Items Influence Recommendations:
```php
// User adds "The Hobbit" to cart
UserBookInteraction::record($userId, $bookId, 'cart'); // Weight: 4.0

// Next recommendation generation includes this signal:
$cartInteractions = UserBookInteraction::where('action', 'cart')
    ->where('user_id', $userId)
    ->get();
    
// Cart weight: 4.0 × count × 0.3 = 1.2 (strong signal!)
// This influences the user's preference profile
// Result: More Fantasy books recommended!
```

---

## 📊 **Complete Flow Diagrams**

### **Flow 1: Homepage "Recommended for You"**

```
┌──────────────────────────────────────────────────────────────┐
│               HOMEPAGE - RECOMMENDED FOR YOU                 │
└──────────────────────────────────────────────────────────────┘

User Visits Homepage
    ↓
Page Loads (Server-side)
    ├─ HomeController@index
    ├─ Checks if user is authenticated
    └─ If Auth::check() = true
        ↓
        recommendForUser(Auth::user(), 6)
        ↓
        HYBRID ALGORITHM RUNS:
        ├─ Content-Based (60%)
        │   ├─ Purchase history
        │   ├─ Wishlist
        │   └─ Interactions (views, clicks, cart)
        │
        └─ Collaborative (40%)
            ├─ Find similar users
            └─ Co-purchase patterns
        ↓
        Final Score = (Content × 0.6) + (Collab × 0.4)
        ↓
        Returns top 6 books to view
    ↓
Page Renders with initial 6 recommendations
    ↓
JavaScript Loads More
    ├─ window.RecommendationManager.loadRecommendations()
    ├─ AJAX: GET /api/recommendations/me?limit=12
    └─ Displays additional recommendations

✅ RESULT: Highly personalized recommendations
```

---

### **Flow 2: Book Detail Page "Similar Books"**

```
┌──────────────────────────────────────────────────────────────┐
│              BOOK DETAIL - SIMILAR BOOKS                     │
└──────────────────────────────────────────────────────────────┘

User Views Book "The Hunger Games"
    ↓
Page Loads
    ↓
JavaScript Runs:
    ├─ window.RecommendationManager.loadSimilarBooks($book->id, 'similar-books-list', 6)
    └─ AJAX: GET /api/recommendations/similar/123?limit=6
        ↓
        RecommendationController@similarToBook($book, $limit)
        ↓
        similarToBook($book, 6)
        ↓
        CONTENT-BASED ALGORITHM RUNS:
        ├─ Extract book features:
        │   ├─ Genre: YA Dystopian
        │   ├─ Tropes: ["Post-apocalyptic", "Teen protagonist"]
        │   └─ Author: Suzanne Collins
        │
        ├─ Find all candidate books (not this one)
        │
        ├─ Score each candidate:
        │   ├─ "Divergent" (YA Dystopian, ["Post-apocalyptic"])
        │   │   └─ Score: 1.0 (genre) + 0.4 (trope) = 1.4
        │   │
        │   ├─ "Catching Fire" (YA Dystopian, same tropes, same author)
        │   │   └─ Score: 1.0 + 0.8 + 0.3 = 2.1
        │   │
        │   └─ "The Maze Runner" (YA Dystopian, ["Teen protagonist"])
        │       └─ Score: 1.0 + 0.4 = 1.4
        │
        └─ Sort by score, return top 6
            ↓
            1. Catching Fire (2.1)
            2. Divergent (1.4)
            3. The Maze Runner (1.4)
            ...

✅ RESULT: Books similar to current book
```

---

### **Flow 3: Cart Page "You Might Also Like"**

```
┌──────────────────────────────────────────────────────────────┐
│              CART/CHECKOUT - YOU MIGHT ALSO LIKE             │
└──────────────────────────────────────────────────────────────┘

User Has Items in Cart
    ├─ Item 1: "Harry Potter" (Fantasy)
    ├─ Item 2: "The Hobbit" (Fantasy)
    └─ UserBookInteraction records:
        ├─ UserBookInteraction(user_id, book_1, 'cart', 4.0, count=1)
        └─ UserBookInteraction(user_id, book_2, 'cart', 4.0, count=1)
    ↓
User Views Cart Page
    ↓
Page Loads
    ↓
JavaScript Runs:
    ├─ window.RecommendationManager.loadRecommendations('cart-recommendations-grid', 8)
    └─ AJAX: GET /api/recommendations/me?limit=8
        ↓
        RecommendationController@forUser($user, $limit)
        ↓
        recommendForUser($user, 8)
        ↓
        HYBRID ALGORITHM RUNS:
        
        CONTENT-BASED (60%):
        ├─ Purchase history: [none yet]
        ├─ Wishlist: [none]
        └─ Interactions:
            ├─ Cart: "Harry Potter" → 4.0 × 1 × 0.3 = 1.2
            ├─ Cart: "The Hobbit" → 4.0 × 1 × 0.3 = 1.2
            └─ Views: Multiple fantasy books viewed
        
        User Profile Built:
        ├─ Genre: Fantasy (weight: 2.4 - strong!)
        ├─ Tropes: "Magic", "Adventure" (weight: 1.7)
        └─ Authors: "J.K. Rowling", "J.R.R. Tolkien" (weight: 1.2)
        
        COLLABORATIVE (40%):
        └─ No purchases yet → Skip
        
        Final Scores:
        ├─ "Lord of the Rings" → Content: 0.95 × 0.6 = 0.57
        ├─ "Percy Jackson" → Content: 0.82 × 0.6 = 0.49
        └─ "Eragon" → Content: 0.78 × 0.6 = 0.47
        
        ↓
        Return top 8 fantasy books

✅ RESULT: Books that complement cart items
✅ GOAL: Increase cart value (cross-sell)
```

---

## 📋 **Summary Table**

| UI Location | Function Used | Algorithm Type | Weights | Why This Choice |
|------------|---------------|----------------|---------|-----------------|
| **Homepage<br>"Recommended for You"** | `recommendForUser()` | **HYBRID** | Content: 60%<br>Collaborative: 40% | Best overall personalization<br>Uses all available data<br>Maximizes engagement |
| **Book Detail<br>"Similar Books"** | `similarToBook()` | **CONTENT-BASED** | Content: 100%<br>Collaborative: 0% | Context-relevant to current book<br>Works for guests<br>Faster computation |
| **Cart/Checkout<br>"You Might Also Like"** | `recommendForUser()` | **HYBRID** | Content: 60%<br>Collaborative: 40% | Conversion-focused<br>Cart items influence profile<br>Cross-sell opportunity |

---

## 🔍 **Key Differences Explained**

### **Why Hybrid for Homepage & Cart but Content-Only for Book Detail?**

#### **Homepage & Cart (Hybrid):**
```
GOAL: Personalize to USER
Focus: What does THIS USER like?
Data Used:
- User's purchase history
- User's wishlist
- User's interactions
- Similar users' patterns
Result: Books tailored to user's taste
```

#### **Book Detail (Content-Only):**
```
GOAL: Relate to CURRENT BOOK
Focus: What's similar to THIS BOOK?
Data Used:
- Current book's genre
- Current book's tropes
- Current book's author
Result: Books similar to current one
```

---

## 🎯 **Real-World Example**

### **Scenario: Sarah's Shopping Journey**

```
STEP 1: Sarah browses homepage
└─ Homepage uses: recommendForUser() (HYBRID)
    ├─ Content: Based on her past purchases (Romance, Mystery)
    └─ Collaborative: Based on similar users who bought Romance+Mystery
    ✅ Shows: Mix of Romance and Mystery books

STEP 2: Sarah clicks "Pride and Prejudice"
└─ Book Detail uses: similarToBook() (CONTENT-BASED)
    ├─ Genre: Romance
    ├─ Tropes: ["Period Drama", "Enemies to Lovers"]
    └─ Author: Jane Austen
    ✅ Shows: "Sense and Sensibility", "Emma", "Persuasion" (similar books)

STEP 3: Sarah adds it to cart
└─ Cart records: UserBookInteraction(cart, weight=4.0)

STEP 4: Sarah views cart
└─ Cart uses: recommendForUser() (HYBRID)
    ├─ Content: Now includes cart item influence (Romance +4.0)
    └─ Collaborative: Users who bought "Pride and Prejudice" also bought...
    ✅ Shows: More Jane Austen books + popular Romance recommendations
```

---

## 💡 **Design Rationale**

### **Why This Architecture is Smart:**

1. **Context-Appropriate**
   - Homepage: User-centric (HYBRID)
   - Book Detail: Item-centric (CONTENT-BASED)
   - Cart: Conversion-centric (HYBRID)

2. **Performance Optimized**
   - Content-based faster (no similar user lookup)
   - Used on high-traffic pages (book detail)
   - Hybrid cached for 30 minutes

3. **Guest User Friendly**
   - Book detail works without login
   - Homepage/Cart require auth (personalized)

4. **Business Goals Aligned**
   - Homepage: Maximize engagement → Hybrid
   - Book Detail: Cross-sell related books → Content-based
   - Cart: Increase order value → Hybrid

---

## 🚀 **API Reference**

### **Endpoint 1: Get User Recommendations (Hybrid)**
```
GET /api/recommendations/me?limit=12
Auth: Required
Returns: Personalized recommendations using HYBRID algorithm

Response:
{
    "data": [
        {
            "id": 1,
            "title": "Book Title",
            "author": "Author Name",
            "price": 29.99,
            "score": 0.85,
            "genre": "Fantasy",
            "tropes": ["Magic School", "Chosen One"],
            "cover_image": "path/to/cover.jpg",
            "link": "/books/1"
        }
    ]
}
```

### **Endpoint 2: Get Similar Books (Content-Based)**
```
GET /api/recommendations/similar/{bookId}?limit=8
Auth: Optional (works for guests)
Returns: Books similar to specified book using CONTENT-BASED algorithm

Response:
{
    "data": [
        {
            "id": 2,
            "title": "Similar Book",
            "author": "Author Name",
            "price": 24.99,
            "score": 0.92,
            "genre": "Fantasy",
            "tropes": ["Magic School"],
            "cover_image": "path/to/cover.jpg",
            "link": "/books/2"
        }
    ]
}
```

---

## ✅ **Conclusion**

Your recommendation system intelligently uses **different algorithms for different contexts**:

- **User-focused pages** (Homepage, Cart) → **HYBRID** for best personalization
- **Item-focused pages** (Book Detail) → **CONTENT-BASED** for relevance

This multi-algorithm approach ensures:
✅ Best recommendations for each context  
✅ Optimal performance  
✅ Guest user support where needed  
✅ Business goals alignment  

The system is **production-ready** and follows **industry best practices**! 🎉

