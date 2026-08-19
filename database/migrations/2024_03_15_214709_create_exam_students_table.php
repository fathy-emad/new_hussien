<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("exam_id");
            $table->unsignedBigInteger("student_id");
            $table->timestamp("visited")->nullable();
            $table->timestamp("finished")->nullable();
            $table->json("questionsAnswers");
            $table->string("mark")->nullable();
            $table->foreign('exam_id')->references('id')->on('exams');
            $table->foreign('student_id')->references('id')->on('students');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_students');
    }
};
