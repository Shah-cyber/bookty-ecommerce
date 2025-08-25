<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 
        'slug', 
        'author', 
        'synopsis', 
        'price', 
        'stock', 
        'cover_image', 
        'genre_id'
    ];
    
    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
    
    public function tropes(): BelongsToMany
    {
        return $this->belongsToMany(Trope::class);
    }
    
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
    
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
