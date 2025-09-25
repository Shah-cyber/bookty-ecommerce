<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewHelpful extends Model
{
    protected $fillable = [
        'review_id',
        'user_id',
    ];

    /**
     * Get the review that was marked as helpful.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * Get the user who marked the review as helpful.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
