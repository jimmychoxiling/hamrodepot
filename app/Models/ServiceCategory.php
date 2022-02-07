<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ServiceCategory extends Model
{
    use HasFactory ,Sluggable;

    protected $fillable = [
        'name',
        'seller_id',
        'slug',
        'image',
        'status',
    ];

    protected $hidden = ['created_at','updated_at'];

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function service()
    {
        return $this->hasMany(Service::class);
    }
}
