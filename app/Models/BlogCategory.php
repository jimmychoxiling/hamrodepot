<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function blogsCount()
    {
        return $this->hasMany(Blog::class, 'blog_category_id', 'id')->count();
    }

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
