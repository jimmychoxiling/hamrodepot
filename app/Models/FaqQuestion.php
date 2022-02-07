<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'ques_category_id',
        'question',
        'answer',
        'status'
    ];
}
