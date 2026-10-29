<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('capacitor_card_lesson_views', function (Blueprint $table) {
            $table->string('last_session_id', 100)->nullable()->after('view_count');
        });
    }

    public function down(): void
    {
        Schema::table('capacitor_card_lesson_views', function (Blueprint $table) {
            $table->dropColumn('last_session_id');
        });
    }
};
