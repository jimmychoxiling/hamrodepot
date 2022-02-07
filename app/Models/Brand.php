<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, Sluggable, SoftDeletes;
    protected $fillable = [
        'name',
        'seller_id',
        'image',
        'slug',
        'status'
    ];

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function seller()
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

    public function products_count()
    {
        return $this->hasMany(Products::class,'brands_id','id')->count();
    }
}
