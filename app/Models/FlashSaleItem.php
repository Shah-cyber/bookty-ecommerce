<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashSaleItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'flash_sale_id',
        'book_id',
        'special_price',
    ];
    
    /**
     * Get the flash sale that owns the item.
     */
    public function flashSale(): BelongsTo
    {
        return $this->belongsTo(FlashSale::class);
    }
    
    /**
     * Get the book that owns the item.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
