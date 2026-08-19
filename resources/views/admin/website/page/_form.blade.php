@php
    $sections = $sections ?? collect();
    $val = fn (string $key, string $field, mixed $default = '') => old(
        str_replace('.', '_', "{$key}_{$field}"),
        $sections->get($key)?->{$field} ?? $default
    );
    $whyPoints = old('why_us_points', $sections->get('why_us')?->extra['points'] ?? array_fill(0, 4, ''));
    $whyPoints = array_slice(array_pad((array) $whyPoints, 4, ''), 0, 4);
@endphp

<div class="accordion" id="websitePageSections">
    <div class="accordion-item mb-3 border rounded">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#sectionHero">
                القسم الرئيسي (Hero)
            </button>
        </h2>
        <div id="sectionHero" class="accordion-collapse collapse show" data-bs-parent="#websitePageSections">
            <div class="accordion-body">
                <div class="input-block mb-3">
                    <label class="form-label" for="hero_title">العنوان</label>
                    <input type="text" class="form-control" id="hero_title" name="hero_title" value="{{ $val('hero', 'title') }}">
                </div>
                <div class="input-block mb-0">
                    <label class="form-label" for="hero_description">الوصف</label>
                    <textarea class="form-control" id="hero_description" name="hero_description" rows="4">{{ $val('hero', 'description') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item mb-3 border rounded">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionWhyUs">
                لماذا تختار مستر حسين؟
            </button>
        </h2>
        <div id="sectionWhyUs" class="accordion-collapse collapse" data-bs-parent="#websitePageSections">
            <div class="accordion-body">
                <div class="input-block mb-3">
                    <label class="form-label" for="why_us_title">العنوان</label>
                    <input type="text" class="form-control" id="why_us_title" name="why_us_title" value="{{ $val('why_us', 'title') }}">
                </div>
                <div class="input-block mb-3">
                    <label class="form-label" for="why_us_description">الوصف</label>
                    <textarea class="form-control" id="why_us_description" name="why_us_description" rows="3">{{ $val('why_us', 'description') }}</textarea>
                </div>
                @for ($i = 0; $i < 4; $i++)
                    <div class="input-block mb-3">
                        <label class="form-label" for="why_us_point_{{ $i + 1 }}">النقطة {{ $i + 1 }}</label>
                        <input
                            type="text"
                            class="form-control"
                            id="why_us_point_{{ $i + 1 }}"
                            name="why_us_points[]"
                            value="{{ $whyPoints[$i] ?? '' }}"
                        >
                    </div>
                @endfor
                <div class="input-block mb-0">
                    <label class="form-label">صورة جانبية (اختياري)</label>
                    <x-admin-dropzone
                        id="why_us_side_image_dropzone"
                        title="اضغط لرفع صورة"
                        description="صورة واحدة بجانب النقاط"
                    />
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item mb-3 border rounded">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionTrending">
                دروس Offline
            </button>
        </h2>
        <div id="sectionTrending" class="accordion-collapse collapse" data-bs-parent="#websitePageSections">
            <div class="accordion-body">
                <p class="text-muted small">يتم عرض جميع دروس Offline المفعّلة تلقائياً من لوحة التحكم.</p>
                <div class="input-block mb-3">
                    <label class="form-label" for="trending_offline_title">العنوان</label>
                    <input type="text" class="form-control" id="trending_offline_title" name="trending_offline_title" value="{{ $val('trending_offline', 'title') }}">
                </div>
                <div class="input-block mb-0">
                    <label class="form-label" for="trending_offline_description">الوصف</label>
                    <textarea class="form-control" id="trending_offline_description" name="trending_offline_description" rows="3">{{ $val('trending_offline', 'description') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item mb-3 border rounded">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionFeatured">
                طلاب متميزون
            </button>
        </h2>
        <div id="sectionFeatured" class="accordion-collapse collapse" data-bs-parent="#websitePageSections">
            <div class="accordion-body">
                <div class="input-block mb-3">
                    <label class="form-label" for="featured_students_title">العنوان</label>
                    <input type="text" class="form-control" id="featured_students_title" name="featured_students_title" value="{{ $val('featured_students', 'title') }}">
                </div>
                <div class="input-block mb-3">
                    <label class="form-label" for="featured_students_description">الوصف</label>
                    <textarea class="form-control" id="featured_students_description" name="featured_students_description" rows="3">{{ $val('featured_students', 'description') }}</textarea>
                </div>
                <div class="input-block mb-0">
                    <label class="form-label">صور الطلاب</label>
                    <x-admin-dropzone
                        id="featured_students_images_dropzone"
                        title="اضغط لإضافة صور الطلاب"
                        description="يمكن رفع عدة صور — افتح هذا القسم قبل الرفع ثم احفظ"
                    />
                    @error('featured_students_images')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    @error('featured_students_images.*')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item mb-3 border rounded">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionReviews">
                آراء الطلاب
            </button>
        </h2>
        <div id="sectionReviews" class="accordion-collapse collapse" data-bs-parent="#websitePageSections">
            <div class="accordion-body">
                <p class="text-muted small">يتم اعتماد الآراء من قائمة «آراء الطلاب» في قسم أخرى.</p>
                <div class="input-block mb-3">
                    <label class="form-label" for="reviews_title">العنوان</label>
                    <input type="text" class="form-control" id="reviews_title" name="reviews_title" value="{{ $val('reviews', 'title') }}">
                </div>
                <div class="input-block mb-0">
                    <label class="form-label" for="reviews_description">الوصف</label>
                    <textarea class="form-control" id="reviews_description" name="reviews_description" rows="3">{{ $val('reviews', 'description') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item mb-3 border rounded">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionCenters">
                السناتر
            </button>
        </h2>
        <div id="sectionCenters" class="accordion-collapse collapse" data-bs-parent="#websitePageSections">
            <div class="accordion-body">
                <p class="text-muted small">يتم عرض السناتر تلقائياً من إعدادات السنتر.</p>
                <div class="input-block mb-3">
                    <label class="form-label" for="centers_title">العنوان</label>
                    <input type="text" class="form-control" id="centers_title" name="centers_title" value="{{ $val('centers', 'title') }}">
                </div>
                <div class="input-block mb-0">
                    <label class="form-label" for="centers_description">الوصف</label>
                    <textarea class="form-control" id="centers_description" name="centers_description" rows="3">{{ $val('centers', 'description') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
