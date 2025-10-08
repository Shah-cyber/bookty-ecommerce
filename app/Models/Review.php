<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'book_id',
        'order_item_id',
        'rating',
        'comment',
        'images',
        'is_approved'
    ];

    protected $casts = [
        'images' => 'array',
    ];
    
    /**
     * Get the user who wrote the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the book that was reviewed.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
    
    /**
     * Get the order item associated with this review.
     */
    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    /**
     * Get the helpful votes for this review.
     */
    public function helpfuls(): HasMany
    {
        return $this->hasMany(ReviewHelpful::class);
    }

    /**
     * Get the reports for this review.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(ReviewReport::class);
    }

    /**
     * Get the helpful count for this review.
     */
    public function getHelpfulCountAttribute(): int
    {
        return $this->helpfuls()->count();
    }

    /**
     * Check if a user has marked this review as helpful.
     */
    public function isMarkedHelpfulBy($userId): bool
    {
        return $this->helpfuls()->where('user_id', $userId)->exists();
    }

    /**
     * Check if a user has reported this review.
     */
    public function isReportedBy($userId): bool
    {
        return $this->reports()->where('user_id', $userId)->exists();
    }

    /**
     * Get the review images with full URLs.
     */
    public function getImageUrlsAttribute(): array
    {
        if (!$this->images) {
            return [];
        }

        return array_map(function ($image) {
            return asset('storage/' . $image);
        }, $this->images);
    }

    /**
     * Check if the review has images.
     */
    public function hasImages(): bool
    {
        return !empty($this->images);
    }

    /**
     * Get the first image URL for thumbnail display.
     */
    public function getFirstImageUrlAttribute(): ?string
    {
        if (!$this->images || empty($this->images)) {
            return null;
        }

        return asset('storage/' . $this->images[0]);
    }
}
