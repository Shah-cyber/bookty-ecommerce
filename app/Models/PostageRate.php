<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostageRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'region',
        'customer_price',
        'actual_cost',
    ];
}


