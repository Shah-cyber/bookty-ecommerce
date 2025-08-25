<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trope extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug', 'description'];
    
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
