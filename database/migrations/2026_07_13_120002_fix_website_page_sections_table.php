<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('website_page_sections')) {
            return;
        }

        Schema::table('website_page_sections', function (Blueprint $table) {
            $table->string('section_key', 100)->change();
        });

        Schema::table('website_page_sections', function (Blueprint $table) {
            $table->unique('section_key');
        });

        if (DB::table('website_page_sections')->count() > 0) {
            return;
        }

        $now = now();

        DB::table('website_page_sections')->insert([
            [
                'section_key' => 'hero',
                'title' => 'منصة مستر حسين التعليمية',
                'description' => 'دروس أونلاين و Offline، امتحانات، ومتابعة مستمرة لمساعدتك على التفوق في مادتك.',
                'extra' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'why_us',
                'title' => 'لماذا تختار مستر حسين؟',
                'description' => 'تجربة تعليمية متكاملة تجمع بين الشرح المبسّط، المتابعة، والامتحانات الإلكترونية.',
                'extra' => json_encode([
                    'points' => [
                        'شرح مبسّط يركز على الفهم والتطبيق',
                        'متابعة مستمرة للطلاب داخل السنتر وأونلاين',
                        'امتحانات إلكترونية وتقارير أداء',
                        'دروس Offline متاحة في أي وقت',
                    ],
                    'side_image' => null,
                ], JSON_UNESCAPED_UNICODE),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'trending_offline',
                'title' => 'دروس Offline المتاحة',
                'description' => 'استكشف أحدث الدروس Offline المفعّلة على المنصة.',
                'extra' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'featured_students',
                'title' => 'طلاب متميزون',
                'description' => 'نفتخر بطلابنا المتميزين الذين يحققون نتائج رائعة مع مستر حسين.',
                'extra' => json_encode(['images' => []], JSON_UNESCAPED_UNICODE),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'reviews',
                'title' => 'آراء الطلاب',
                'description' => 'اطلع على تجارب طلابنا الحقيقية مع مستر حسين.',
                'extra' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'section_key' => 'centers',
                'title' => 'سناترنا',
                'description' => 'تعرف على مواقع سناتر مستر حسين وعناوينها.',
                'extra' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('website_page_sections')) {
            return;
        }

        Schema::table('website_page_sections', function (Blueprint $table) {
            $table->dropUnique(['section_key']);
        });
    }
};
