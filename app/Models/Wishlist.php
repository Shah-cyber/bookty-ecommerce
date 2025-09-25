<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'book_id'
    ];
    
    /**
     * Get the user that owns the wishlist item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the book in the wishlist.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
