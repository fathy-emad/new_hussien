<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'active', 'images'];
    protected $table = ['website_settings'];
    public $timestamps = false;
}
