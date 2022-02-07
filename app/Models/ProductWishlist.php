<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWishlist extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id'
    ];


    public function product()
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }
}
