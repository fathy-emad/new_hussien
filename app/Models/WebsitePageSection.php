<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsitePageSection extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'description',
        'extra',
        'is_active',
    ];

    protected $casts = [
        'extra' => 'array',
        'is_active' => 'boolean',
    ];
}
