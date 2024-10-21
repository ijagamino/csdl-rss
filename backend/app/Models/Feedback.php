<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
