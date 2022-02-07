<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, Billable, Sluggable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'country_id',
        'gender',
        'business_name',
        'address_line1',
        'address_line2',
        'state',
        'city',
        'zipcode',
        'phone_number_type',
        'phone_number',
        'product_plan_to_list',
        'shipping_method',
        'birth_date',
        'status',
        'slug',
        'i_agree',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sluggable(): array{
        return [
            'slug' => [
                'source' => 'business_name'
            ]
        ];
    }

    public function brand()
    {
        $this->hasMany(Brand::class, 'seller_id', 'id');
    }
    public function country()
    {
        return $this->hasOne(Country::class,'id','country_id');
    }
    public function address()
    {
       return $this->hasMany(UserAddress::class, 'user_id', 'id');
    }

    public function addressFirst()
    {
        return $this->hasOne(UserAddress::class, 'user_id', 'id');
    }
    public function sellerHours()
    {
       return $this->hasMany(SellerOpeningHour::class, 'user_id', 'id');
    }

}
