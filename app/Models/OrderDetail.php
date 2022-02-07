<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
      'order_id',
        'product_id',
        'seller_id',
        'name',
        'sku',
        'sell_type',
        'from_date',
        'to_date',
        'from_time',
        'to_time',
        'total_hrs',
        'price',
        'quantity',
        'sub_total',
        'total',
        'commission',
        'commission_total',
        'discount',
        'voucher_id',
    ];

    public function product()
    {
        return $this->hasOne(Products::class,'id','product_id');
    }

    public function orderStatusLast()
    {
        return $this->hasOne(OrderStatusHistory::class,'order_detail_id','id')->orderBy('id','DESC');
    }

    public function orderStatusHistory()
    {
        return $this->hasMany(OrderStatusHistory::class,'order_detail_id','id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

    public function orders()
    {
        return $this->hasOne(Orders::class, 'id', 'order_id');
    }
    public function products()
    {
        return $this->hasMany(Products::class,'id','product_id');
    }
}
