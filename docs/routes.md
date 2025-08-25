## HTTP Routes

This document enumerates public endpoints with HTTP verbs, middleware, names, and brief descriptions.

### Customer routes
- GET `/` (name: `home`)
  - Controller: `HomeController@index`
  - Description: Home page with new arrivals and highlighted genres.

- GET `/books` (name: `books.index`)
  - Controller: `BookController@index`
  - Query params:
    - `genre` (int): Filter by `genres.id`
    - `trope` (int): Filter by `tropes.id`
    - `price_min` (number), `price_max` (number)
    - `sort` (enum): `newest` | `price_asc` | `price_desc` | `title_asc` | `title_desc`
  - Example (Blade):
    ```blade
    <a href="{{ route('books.index', ['genre' => 3, 'sort' => 'price_asc']) }}">View</a>
    ```

- GET `/books/{book:slug}` (name: `books.show`)
  - Controller: `BookController@show`

- GET `/about` (name: `about`)
  - Controller: `AboutController@index`

### Dashboard redirect (protected)
- GET `/dashboard` (name: `dashboard`) [middleware: `auth`, `verified`]
  - Redirects users according to role: `superadmin` -> `/superadmin`, `admin` -> `/admin`, else home.

### Profile (protected)
- GET `/profile` (name: `profile.edit`) [auth]
- PATCH `/profile` (name: `profile.update`) [auth]
- DELETE `/profile` (name: `profile.destroy`) [auth]
- GET `/profile/orders` (name: `profile.orders`) [auth]
- GET `/profile/orders/{order}` (name: `profile.orders.show`) [auth]

### Cart and Checkout (protected)
- GET `/cart` (name: `cart.index`) [auth]
- POST `/cart/add/{book}` (name: `cart.add`) [auth]
  - Body: `quantity` (int, min 1, max = book stock)
  - Example (Blade):
    ```blade
    <form method="POST" action="{{ route('cart.add', $book) }}">
        @csrf
        <input type="number" name="quantity" value="1" min="1" max="{{ $book->stock }}">
        <button type="submit">Add to cart</button>
    </form>
    ```
- PATCH `/cart/update/{cartItem}` (name: `cart.update`) [auth]
- DELETE `/cart/remove/{cartItem}` (name: `cart.remove`) [auth]

- GET `/checkout` (name: `checkout.index`) [auth]
- POST `/checkout` (name: `checkout.process`) [auth]
  - Body: `shipping_address`, `shipping_city`, `shipping_state`, `shipping_postal_code`, `shipping_phone`
- GET `/checkout/success` (name: `checkout.success`) [auth]

### Admin (protected; middleware: `auth`, `role:admin,superadmin`; prefix `admin.`)
- GET `/admin` (name: `admin.dashboard`)
- Resource: `/admin/books` (name: `admin.books.*`)
- Resource: `/admin/genres` (name: `admin.genres.*`)
- Resource: `/admin/tropes` (name: `admin.tropes.*`)
- Resource: `/admin/orders` (name: `admin.orders.*`)
- Resource: `/admin/customers` (name: `admin.customers.*`) [only: `index`, `show`]

Resource conventions map to:
- index: GET `/resource`
- create: GET `/resource/create`
- store: POST `/resource`
- show: GET `/resource/{id}`
- edit: GET `/resource/{id}/edit`
- update: PUT/PATCH `/resource/{id}`
- destroy: DELETE `/resource/{id}`

### Superadmin (protected; middleware: `auth`, `role:superadmin`; prefix `superadmin.`)
- GET `/superadmin` (name: `superadmin.dashboard`)
- Resource: `/superadmin/admins` (name: `superadmin.admins.*`)
- GET `/superadmin/settings` (name: `superadmin.settings.index`)
- POST `/superadmin/settings` (name: `superadmin.settings.update`)
- Resource: `/superadmin/roles` (name: `superadmin.roles.*`)
- Resource: `/superadmin/permissions` (name: `superadmin.permissions.*`)

### Authentication routes
- GET `register` (name: `register`) [guest]
- POST `register` [guest]
- GET `login` (name: `login`) [guest]
- POST `login` [guest]
- GET `forgot-password` (name: `password.request`) [guest]
- POST `forgot-password` (name: `password.email`) [guest]
- GET `reset-password/{token}` (name: `password.reset`) [guest]
- POST `reset-password` (name: `password.store`) [guest]
- GET `verify-email` (name: `verification.notice`) [auth]
- GET `verify-email/{id}/{hash}` (name: `verification.verify`) [auth, `signed`, `throttle:6,1`]
- POST `email/verification-notification` (name: `verification.send`) [auth, `throttle:6,1`]
- GET `confirm-password` (name: `password.confirm`) [auth]
- POST `confirm-password` [auth]
- PUT `password` (name: `password.update`) [auth]
- POST `logout` (name: `logout`) [auth]

