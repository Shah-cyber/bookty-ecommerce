## Models

Eloquent models, attributes, relationships, and helper methods.

### Book
- Fillable: `title`, `slug`, `author`, `synopsis`, `price`, `stock`, `cover_image`, `genre_id`
- Relationships:
  - `genre()` → BelongsTo `Genre`
  - `tropes()` → BelongsToMany `Trope`
  - `orderItems()` → HasMany `OrderItem`
  - `cartItems()` → HasMany `CartItem`
- Example:
```php
$books = Book::with(['genre', 'tropes'])->where('stock', '>', 0)->paginate(12);
```

### Genre
- Fillable: `name`, `slug`, `description`
- Relationships: `books()` → HasMany `Book`

### Trope
- Fillable: `name`, `slug`, `description`
- Relationships: `books()` → BelongsToMany `Book`

### Cart
- Fillable: `user_id`
- Relationships: `user()` → BelongsTo `User`, `items()` → HasMany `CartItem`

### CartItem
- Fillable: `cart_id`, `book_id`, `quantity`
- Relationships: `cart()` → BelongsTo `Cart`, `book()` → BelongsTo `Book`

### Order
- Fillable: `user_id`, `total_amount`, `status`, `payment_status`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_postal_code`, `shipping_phone`, `admin_notes`
- Relationships: `user()` → BelongsTo `User`, `items()` → HasMany `OrderItem`
- Helpers:
  - `getStatusBadgeClass(): string`
  - `getPaymentStatusBadgeClass(): string`
  - `getTotalQuantity(): int`

### OrderItem
- Fillable: `order_id`, `book_id`, `quantity`, `price`
- Relationships: `order()` → BelongsTo `Order`, `book()` → BelongsTo `Book`

### Setting
- Fillable: `key`, `value`, `group`
- Statics:
  - `Setting::getValue(string $key, $default = null)`
  - `Setting::setValue(string $key, $value, string $group = 'general')`
- Examples:
```php
$brandName = Setting::getValue('brand.name', 'Bookty');
Setting::setValue('homepage.banner', 'Welcome to Bookty', 'ui');
```

