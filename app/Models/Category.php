<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'image',
        'slug',
        'parent_id',
        'level',
        'show_home_page',
        'show_home_top_category',
        'status'
    ];

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
//    public function subCategory()
//    {
//        return $this->hasMany(SubCategory::class, 'category_id', 'id');
//    }
    public function subCategoryParent()
    {
        return $this->belongsTo(static::class, 'parent_id');;
    }
}
