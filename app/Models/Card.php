<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'link',
        'badge',
        'preview_url',
        'type',
        'is_coming_soon',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_coming_soon' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}

