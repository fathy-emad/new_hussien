<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('capacitor_card_lesson_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capacitor_card_id')->constrained()->cascadeOnDelete();
            $table->foreignId('capacitor_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamps();

            $table->unique(['capacitor_card_id', 'capacitor_id'], 'cap_card_lesson_views_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capacitor_card_lesson_views');
    }
};
