<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [

        'seller_id',
        'name',
        'slug',
        'sku',
        'description',
        'sell_type',
        'price',
        'stock',
        'brands_id',
        'status',
        'product_overview',
        'specifications',
        'easy_returns',
        'show_home_feature'
    ];

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function productsImages()
    {
        return  $this->hasMany(ProductsImages::class, 'product_id', 'id');
    }


    public function productsImagesFirst()
    {
        return $this->hasOne(ProductsImages::class, 'product_id', 'id');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brands_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

    public function productWishlist()
    {
        return $this->hasOne(productWishlist::class, 'product_id', 'id');
    }

    public function productRating()
    {
        return $this->hasOne(ProductRating::class, 'product_id', 'id');
    }

    public function productRatings()
    {
        return  $this->hasMany(ProductRating::class, 'product_id', 'id');
    }


}
