<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'age',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get the wishlist items for the user.
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
    
    /**
     * Get books in the user's wishlist.
     */
    public function wishlistBooks()
    {
        return $this->belongsToMany(Book::class, 'wishlists')->withTimestamps();
    }
    
    /**
     * Check if a book is in the user's wishlist.
     *
     * @param int $bookId
     * @return bool
     */
    public function hasBookInWishlist($bookId)
    {
        return $this->wishlist()->where('book_id', $bookId)->exists();
    }
    
    /**
     * Check if user has purchased a specific book and is eligible to review it
     * 
     * @param int $bookId
     * @return bool
     */
    public function canReviewBook($bookId)
    {
        return $this->orders()
            ->where('status', 'completed')
            ->whereHas('items', function($query) use ($bookId) {
                $query->where('book_id', $bookId);
            })
            ->exists();
    }
    
    /**
     * Check if user has already reviewed a specific book
     * 
     * @param int $bookId
     * @return bool
     */
    public function hasReviewedBook($bookId)
    {
        return $this->reviews()
            ->where('book_id', $bookId)
            ->exists();
    }
    
    /**
     * Get order item for a specific book that can be reviewed
     * 
     * @param int $bookId
     * @return OrderItem|null
     */
    public function getOrderItemForBookReview($bookId)
    {
        return OrderItem::whereHas('order', function($query) {
                $query->where('user_id', $this->id)
                      ->where('status', 'completed');
            })
            ->where('book_id', $bookId)
            ->whereDoesntHave('review')
            ->first();
    }
    
    /**
     * Check if user profile is incomplete (missing shipping information)
     * 
     * @return bool
     */
    public function hasIncompleteProfile(): bool
    {
        return empty($this->address_line1) || 
               empty($this->city) || 
               empty($this->state) || 
               empty($this->postal_code) || 
               empty($this->phone_number);
    }
    
    /**
     * Get profile completion percentage
     * 
     * @return int Percentage (0-100)
     */
    public function getProfileCompletionPercentage(): int
    {
        $fields = [
            'address_line1',
            'city',
            'state',
            'postal_code',
            'phone_number',
        ];
        
        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }
        
        return (int) round(($completed / count($fields)) * 100);
    }
}
