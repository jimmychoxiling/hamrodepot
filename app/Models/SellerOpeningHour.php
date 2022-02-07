<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerOpeningHour extends Model
{
    use HasFactory;
    protected $fillable = [
        'day',
        'isOpen',
        'user_id',
        'opening_time',
        'closing_time',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
