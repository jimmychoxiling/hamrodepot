<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at','updated_at'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
