## Controllers

Public controller actions and responsibilities.

### HomeController
- `index()`
  - Returns `home.index` with `newArrivals` and top `genres`.

### AboutController
- `index()`
  - Returns `about.index`.

### BookController (Customer)
- `index(Request $request)`
  - Filters: `genre`, `trope`, `price_min`, `price_max`.
  - Sorting: `newest` (default), `price_asc`, `price_desc`, `title_asc`, `title_desc`.
  - Returns `books.index` with `books`, `genres`, `tropes`.
- `show(Book $book)`
  - Loads `genre`, `tropes` and finds related books in same genre.
  - Returns `books.show` with `book`, `relatedBooks`.

### ProfileController (auth)
- `edit(Request $request)` → `profile.edit`
- `update(ProfileUpdateRequest $request)`
  - Updates profile; resets `email_verified_at` if email changed.
- `destroy(Request $request)`
  - Requires `current_password`, logs out, deletes user, clears session.
- `orders(Request $request)` → `profile.orders` (paginated)
- `showOrder(Request $request, $id)` → `profile.order-detail`

### CartController (auth)
- `index()` → `cart.index`
- `add(Request $request, Book $book)`
  - Validates `quantity` in stock; creates/updates `CartItem`.
- `update(Request $request, CartItem $cartItem)`
  - Validates ownership and `quantity`.
- `remove(CartItem $cartItem)`
  - Validates ownership; deletes item.

Example add-to-cart form:
```blade
<form method="POST" action="{{ route('cart.add', $book) }}">
    @csrf
    <input type="number" name="quantity" value="1" min="1" max="{{ $book->stock }}">
    <x-primary-button>Add</x-primary-button>
    </form>
```

### CheckoutController (auth)
- `index()` → `checkout.index` if cart has items; else redirects to cart.
- `process(Request $request)`
  - Validates shipping fields; creates `Order` and `OrderItem`s transactionally; decrements stock; sets `payment_status` to `paid`.
- `success(Request $request)`
  - Ensures order belongs to user; returns `checkout.success` with `order`.

### Admin\BookController (admin/superadmin)
- `index()` → `admin.books.index`
- `create()` → `admin.books.create`
- `store(Request)` → validates, uploads optional `cover_image`, creates, syncs `tropes`.
- `show(Book $book)` → `admin.books.show`
- `edit(Book $book)` → `admin.books.edit`
- `update(Request, Book)` → validates, optionally replaces cover image, updates, syncs `tropes`.
- `destroy(Book $book)` → deletes cover image and book.

Other admin/superadmin resource controllers follow standard resource actions per `routes.md`.

