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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('code')->unique();
            $table->string('phone')->unique();
            $table->string('whatsApp')->nullable();
            $table->integer('gender')->nullable();
            $table->string('father_phone')->unique();
            $table->string('academic_year')->nullable();
            $table->string('classroom')->nullable();
            $table->foreignId('center_id')->nullable()->constrained();
            $table->smallInteger('material_one')->default(0);
            $table->smallInteger('material_two')->default(0);
            $table->smallInteger('material_three')->default(0);
            $table->smallInteger('material_four')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('admins');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('admins');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
