<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['time' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
