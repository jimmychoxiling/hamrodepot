<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'user_id',
        'country_id',
        'address_line1',
        'address_line2',
        'state',
        'city',
        'zipcode',
        'phone_number',
        'address_type',
        'delivery_type',
        'phone_number_type',
        'default_address'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function country()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }
}
