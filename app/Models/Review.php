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
        'is_approved'
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
}
