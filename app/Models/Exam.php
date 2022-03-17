<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Exam extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'course_id',
        'hall_id',
        'day',
        'start',
        'end',
    ];
}
