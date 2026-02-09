<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Trope;
use App\Models\User;
use App\Models\UserBookInteraction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * Seeds dummy data for the hybrid recommendation system (strict threshold 0.3).
 * Creates: many books (no cover), customer users, completed orders with overlap
 * so content-based and collaborative filtering both have data.
 *
 * Run after: RolesAndPermissionsSeeder, GenreSeeder, TropeSeeder
 * Run: php artisan db:seed --class=RecommendationDummyDataSeeder
 */
class RecommendationDummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        $genres = Genre::all();
        $tropes = Trope::all();
        if ($genres->isEmpty() || $tropes->isEmpty()) {
            $this->command->warn('Run GenreSeeder and TropeSeeder first.');
            return;
        }

        $this->command->info('Creating dummy books (no cover)...');
        $books = $this->createBooks($genres, $tropes);

        $this->command->info('Creating dummy customer users...');
        $users = $this->createUsers($customerRole);

        $this->command->info('Creating completed orders with overlap for CF...');
        $this->createOrdersWithOverlap($users, $books);

        $this->command->info('Creating user-book interactions (views/clicks)...');
        $this->createInteractions($users, $books);

        $this->command->info('Recommendation dummy data seeded successfully.');
    }

    /**
     * Create many books without cover_image. Spread across genres and tropes.
     *
     * @return \Illuminate\Support\Collection<int, Book>
     */
    private function createBooks($genres, $tropes): \Illuminate\Support\Collection
    {
        $titles = [
            'Lily His Forbidden Love', 'Midnight Garden', 'The Last Letter', 'Summer at the Lake',
            'Echoes of You', 'Between the Lines', 'One Night in Paris', 'The Secret We Keep',
            'When We Meet Again', 'Forever Yours', 'Stolen Moments', 'The Promise',
            'Hidden Hearts', 'Second Chances', 'Love in the Rain', 'Whispers of Winter',
            'Beneath the Stars', 'The Art of Letting Go', 'First Light', 'Broken Vows',
            'Tangled Lies', 'Sweet Surrender', 'No Ordinary Love', 'The Way Back',
            'Falling for You', 'Once Upon a Dream', 'Silent Promises', 'Beyond the Horizon',
            'Tides of Love', 'The Forgotten Garden', 'In Another Life', 'Until Tomorrow',
            'A Place to Call Home', 'The Long Road', 'Shadows and Light', 'Winter Rose',
            'The Last Dance', 'Moonlit Secrets', 'Heart of Gold', 'Distant Shores',
            'The Letter', 'Chasing Dreams', 'Wild at Heart', 'Quiet Storm',
            'The Choice', 'After the Rain', 'True North', 'Silver Lining',
            'The Gift', 'Homecoming', 'Riverside', 'The Bridge',
            'Northern Lights', 'Southern Comfort', 'East of Eden', 'West Wind',
            'Autumn Leaves', 'Spring Fever', 'Summer Storm', 'Winter Song',
            'The Inn', 'The Cottage', 'The Villa', 'The Lodge',
            'Blue Skies', 'Gray Days', 'Golden Hour', 'Crimson Tide',
        ];

        $authors = [
            'Aina Emir', 'Siti Nurhaliza', 'Ahmad Fadli', 'Maria Abdullah',
            'James Lee', 'Sarah Chen', 'Nurul Iman', 'David Wong',
            'Lisa Tan', 'Amir Hassan', 'Emily Rose', 'Rizal Ahmad',
        ];

        $created = collect();
        $usedSlugs = [];

        foreach (array_slice($titles, 0, 70) as $i => $title) {
            $baseSlug = Str::slug($title);
            $slug = $baseSlug;
            $counter = 1;
            
            // Ensure unique slug - check database and used slugs
            while (Book::where('slug', $slug)->exists() || isset($usedSlugs[$slug])) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $usedSlugs[$slug] = true;

            // Check if book already exists by slug
            $book = Book::where('slug', $slug)->first();
            
            if (!$book) {
                $genre = $genres->random();
                $book = Book::create([
                    'title' => $title,
                    'slug' => $slug,
                    'author' => $authors[array_rand($authors)],
                    'synopsis' => 'A compelling story about love, loss, and second chances. ' . Str::random(80),
                    'price' => rand(25, 85) + (rand(0, 99) / 100),
                    'cost_price' => rand(15, 45) + (rand(0, 99) / 100),
                    'stock' => rand(5, 50),
                    'cover_image' => null, // No cover
                    'genre_id' => $genre->id,
                    'condition' => ['new', 'preloved'][rand(0, 1)],
                ]);

                // Attach 2–4 random tropes per book for content-based matching
                $book->tropes()->attach($tropes->random(rand(2, min(4, $tropes->count())))->pluck('id'));
            }
            
            $created->push($book);
        }

        return $created;
    }

    /**
     * Create dummy customer users (do not overwrite existing).
     *
     * @return \Illuminate\Support\Collection<int, User>
     */
    private function createUsers(Role $customerRole): \Illuminate\Support\Collection
    {
        $names = [
            'Ahmad bin Hassan', 'Siti Nurul', 'Lee Ming', 'Nurul Izzati',
            'Raj Kumar', 'Fatimah Zahra', 'Chen Wei', 'Amirah binti Omar',
            'John Doe', 'Jane Smith', 'Ali Rahman', 'Maya Santos',
            'David Tan', 'Priya Sharma', 'Omar Khalid', 'Yuki Tanaka',
            'Hassan Ali', 'Lina Wong', 'Marcus Lee', 'Zara Ibrahim',
            'Ryan Ng', 'Sofia Martinez', 'Adam bin Yusof', 'Emma Wilson',
        ];

        $result = collect();
        foreach (array_slice($names, 0, 22) as $i => $name) {
            $email = 'dummy' . ($i + 1) . '@recommendation.local';
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                ]
            );
            if (!$user->hasRole('customer')) {
                $user->assignRole($customerRole);
            }
            $result->push($user);
        }

        return $result;
    }

    /**
     * Create completed orders so that:
     * - Each user has several orders (purchase history for content-based).
     * - Some books are bought by multiple users (overlap for collaborative).
     */
    private function createOrdersWithOverlap($users, $books): void
    {
        $bookIds = $books->pluck('id')->all();

        foreach ($users as $user) {
            $numOrders = rand(4, 10);
            for ($o = 0; $o < $numOrders; $o++) {
                $itemCount = rand(1, 4);
                $orderBookIds = (array) array_rand(array_flip($bookIds), min($itemCount, count($bookIds)));
                if (!is_array($orderBookIds)) {
                    $orderBookIds = [$orderBookIds];
                }

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => 0,
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'shipping_address' => '123 Dummy St, City',
                    'shipping_city' => 'Kuala Lumpur',
                    'shipping_state' => 'Selangor',
                    'shipping_region' => 'sm', // Valid enum: 'sm', 'sabah', 'sarawak', 'labuan'
                    'shipping_customer_price' => 8.00,
                    'shipping_actual_cost' => 5.00,
                    'shipping_postal_code' => '50000',
                    'shipping_phone' => '0123456789',
                ]);

                $total = 0;
                foreach ($orderBookIds as $bookId) {
                    $book = $books->firstWhere('id', $bookId) ?? Book::find($bookId);
                    if (!$book) continue;
                    $qty = rand(1, 2);
                    $price = $book->price;
                    $cost = $book->cost_price ?? $book->price * 0.6;
                    $totalSelling = $price * $qty;
                    $totalCost = $cost * $qty;
                    OrderItem::create([
                        'order_id' => $order->id,
                        'book_id' => $book->id,
                        'quantity' => $qty,
                        'price' => $price,
                        'cost_price' => $cost,
                        'total_selling' => $totalSelling,
                        'total_cost' => $totalCost,
                    ]);
                    $total += $totalSelling;
                }

                $order->update(['total_amount' => $total + 8.00]);
            }
        }

        // Ensure overlap: same books bought by multiple users (for collaborative filtering)
        $popularBookIds = collect($bookIds)->random(min(15, count($bookIds)));
        foreach ($popularBookIds as $bookId) {
            $buyers = $users->random(min(5, $users->count()));
            foreach ($buyers as $user) {
                $existing = OrderItem::whereHas('order', fn ($q) => $q->where('user_id', $user->id)->where('status', 'completed'))
                    ->where('book_id', $bookId)->exists();
                if ($existing) continue;

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_amount' => 0,
                    'status' => 'completed',
                    'payment_status' => 'paid',
                    'shipping_address' => '123 Dummy St',
                    'shipping_city' => 'Kuala Lumpur',
                    'shipping_state' => 'Selangor',
                    'shipping_region' => 'sm', // Valid enum: 'sm', 'sabah', 'sarawak', 'labuan'
                    'shipping_customer_price' => 8.00,
                    'shipping_actual_cost' => 5.00,
                    'shipping_postal_code' => '50000',
                    'shipping_phone' => '0123456789',
                ]);
                $book = Book::find($bookId);
                if (!$book) continue;
                $price = $book->price;
                $cost = $book->cost_price ?? $book->price * 0.6;
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'quantity' => 1,
                    'price' => $price,
                    'cost_price' => $cost,
                    'total_selling' => $price,
                    'total_cost' => $cost,
                ]);
                $order->update(['total_amount' => $price + 8.00]);
            }
        }
    }

    /**
     * Create view/click interactions for some user-book pairs (content-based cold-start).
     */
    private function createInteractions($users, $books): void
    {
        $actions = ['view' => 1.0, 'click' => 1.5];
        $userCount = min(10, $users->count());
        $bookCount = min(8, $books->count());
        if ($userCount === 0 || $bookCount === 0) {
            return;
        }
        $selectedUsers = $users->random($userCount);
        $selectedBooks = $books->random($bookCount);
        foreach ($selectedUsers as $user) {
            foreach ($selectedBooks as $book) {
                $action = array_rand($actions);
                UserBookInteraction::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                        'action' => $action,
                    ],
                    [
                        'weight' => $actions[$action],
                        'count' => rand(1, 5),
                        'last_interacted_at' => now()->subDays(rand(0, 30)),
                    ]
                );
            }
        }
    }
}
