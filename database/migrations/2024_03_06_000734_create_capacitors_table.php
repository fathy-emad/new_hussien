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
        Schema::create('capacitors', function (Blueprint $table) {
            $table->id();
            $table->string('classroom');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('link');
            $table->string('thumbnail')->nullable();
            $table->longText('images')->nullable();
            $table->longText('pdf')->nullable();
            $table->boolean("active")->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('admins');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capacitors');
    }
};
