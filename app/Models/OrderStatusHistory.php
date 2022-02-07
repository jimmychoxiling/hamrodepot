<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_detail_id',
        'status_id'
    ];

    public function OrderStatus()
    {
        return $this->hasOne(OrderStatus::class, 'id','status_id');
    }
}
