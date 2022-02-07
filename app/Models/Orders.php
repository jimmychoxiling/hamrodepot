<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'shipping_address_id',
        'order_no',
        'sub_total',
        'total',
        'commission_total',
        'payment_method',
        'payment_method_title',
        'payment_status',
        'payment_intent',
        'stripe_response',
        'receipt_url',
        'discount',
        'voucher_id',

    ];

    public function shippingAddress()
    {
        return $this->hasOne(UserAddress::class, 'id', 'shipping_address_id');
    }

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
