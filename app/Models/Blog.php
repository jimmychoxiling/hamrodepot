<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'blog_category_id',
        'name',
        'description',
        'image',
        'author',
        'slug'
    ];

    public function blogCategory()
    {
        return $this->hasOne(BlogCategory::class, 'id', 'blog_category_id');
    }
    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
