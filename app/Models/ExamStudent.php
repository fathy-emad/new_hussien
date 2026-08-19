<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamStudent extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "visited" => "datetime",
        "finished" => "datetime",
        "questionsAnswers" => "array"
    ];

    // public function question(): BelongsToJson
    // {
    //     return $this->belongsToJson(BankQuestion::class, "questionsAnswers.question");
    // }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, "exam_id");
    }

}
