<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('capacitor_card_lesson_views')) {
            return;
        }

        Schema::table('capacitor_card_lesson_views', function (Blueprint $table) {
            $table->unique(['capacitor_card_id', 'capacitor_id'], 'cap_card_lesson_views_unique');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('capacitor_card_lesson_views')) {
            return;
        }

        Schema::table('capacitor_card_lesson_views', function (Blueprint $table) {
            $table->dropUnique('cap_card_lesson_views_unique');
        });
    }
};
