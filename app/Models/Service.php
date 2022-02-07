<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Service extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = [];

    protected $hidden = ['created_at','updated_at'];

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
    
    public function addresses()
    {
        return  $this->hasMany(ServiceAddress::class, 'service_id', 'id');
    }
    
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id', 'id');
    }
}
