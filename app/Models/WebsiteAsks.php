<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteAsks extends Model
{
    use HasFactory;

    protected $table = 'website_asks';

    protected $fillable = ['content', 'phone', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean',
    ];
}
