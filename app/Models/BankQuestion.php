<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'answers' => 'array'
    ];


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }

}
