<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legislation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'rate',
        'review',
    ];

    protected $casts = [
        'rate' => 'integer',
    ];
}

