<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBookInteraction extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'action',
        'weight',
        'count',
        'last_interacted_at',
    ];

    protected $casts = [
        'weight' => 'decimal:1',
        'count' => 'integer',
        'last_interacted_at' => 'datetime',
    ];

    // Action weights mapping
    public const ACTION_WEIGHTS = [
        'view' => 1.0,
        'click' => 1.5,
        'wishlist' => 3.0,
        'cart' => 4.0,
        'purchase' => 5.0,
    ];

    /**
     * Get the user that owns the interaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was interacted with.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Record or update an interaction.
     * 
     * @param int $userId
     * @param int $bookId
     * @param string $action
     * @return self
     */
    public static function record(int $userId, int $bookId, string $action): self
    {
        $weight = self::ACTION_WEIGHTS[$action] ?? 1.0;

        $interaction = self::firstOrNew([
            'user_id' => $userId,
            'book_id' => $bookId,
            'action' => $action,
        ]);

        $interaction->weight = $weight;
        $interaction->count = ($interaction->count ?? 0) + 1;
        $interaction->last_interacted_at = now();
        $interaction->save();

        return $interaction;
    }
}
