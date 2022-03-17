<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Profile extends Model
{

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'phone',
        'address',
        'gender',
        'age',
        'degree',
        'user_id',
        'college_id',
    ];
}
