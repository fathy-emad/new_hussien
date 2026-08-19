<?php

use App\Constants\Constants;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/**
 *
 * get all validation error message of rules from lang file to pass them to js validator
 *
 * @param array $rules
 * @return string
 *
 */
if (! function_exists('getValidationErrorMessages')) {
    function getValidationErrorMessages(array $rules = []): string
    {

        $lang = app()->getLocale();

        $rulesFile = include "../lang/$lang/validation.php";

        foreach ($rules as $rule) {

            $explodeRule = explode(".", $rule);
            $ruleName = $explodeRule[0];
            $ruleType = $explodeRule[1] ?? '';

            $validationErrorMessages[$rule] = is_string($rulesFile[$ruleName]) ? $rulesFile[$ruleName] : $rulesFile[$ruleName][$ruleType];
        }

        return json_encode($validationErrorMessages ?? [], JSON_UNESCAPED_UNICODE);
    }
}


/**
 *
 * imploding error messages to view as string if found
 *
 * @param object $errors
 * @param string $inputName
 * @return string
 *
 *
 */
if (! function_exists('getValidationErrorMessage')) {
    function getValidationErrorMessage(object $errors, string $inputName): string
    {

        return $errors->get($inputName) ? implode(', ', $errors->get($inputName)) : '';
    }
}

/**
 *
 * set css class (is-invalid) to input if errors found
 *
 * @param object $errors
 * @param string $inputName
 * @return string
 *
 */
if (! function_exists('getValidationErrorClass')) {
    function getValidationErrorClass(object $errors, string $inputName): string
    {
        return $errors->get($inputName) ? 'is-invalid' : '';
    }
}


/**
 *
 * get specific constant
 *
 *
 * @param string $constant
 * @return Constants
 *
 *
 */
if (! function_exists('getConstant')) {
    function getConstant(string $constant): Constants
    {
        return new Constants($constant);
    }
}

if (! function_exists('getAcademicYears')) {
    function getAcademicYears(): array
    {
        $current = (int) date('Y');
        $years = [];

        for ($year = $current + 1; $year >= $current - 5; $year--) {
            $years[$year] = (string) $year;
        }

        return $years;
    }
}

/**
 *
 * get sidebar menu routes
 *
 * @return array
 */
if (! function_exists('getAdminMenu')) {
    function getAdminMenu(): array
    {
        $admin_id = Auth::guard('admin')->user()->id;
        $admin_permissions = Admin::find($admin_id)->permission->permissions;
        foreach (explode(',', $admin_permissions) AS $permission)
        {
            if ($permission == 'dashboard') {
                $permissions[] = $permission;
            } else {
                $explode_permission = explode(".", $permission);
                $permissions[$explode_permission[0]][$explode_permission[1]][] = $explode_permission[2];
            }
        }
        return $permissions;
    }
}


if (! function_exists('getAdminViewRoutes')) {
    function getAdminViewRoutes(): array
    {

        $routes = collect(Route::getRoutes())->map(function ($route) {

            $explode = explode('/', $route->uri());
            $guard = $explode[0] ?? '';
            $main = $explode[1] ?? '';
            $sub = $explode[2] ?? '';
            $page = $explode[3] ?? '';

            if($route->methods()[0] == 'GET' && $guard == 'admin') return [ 'main' => $main, 'sub' => $sub, 'page' => $page ];

        });

        foreach ($routes AS $route) {
            if ($route && $route['sub'] && !in_array($route['page'], ["edit", "view"])) $return[$route['main']][$route['sub']][] = $route['page'];
        }
        return $return;
    }
}

if (! function_exists('resolveUploadedFilename')) {
    /** Single Dropzone file (e.g. student avatar): first file only. */
    function resolveUploadedFilename(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value[0] ?? null;
        }

        $value = is_string($value) ? trim($value) : null;

        return normalizeStoredFilename($value);
    }
}

if (! function_exists('resolveStoredVideoFilename')) {
    /**
     * Filename for DB (lessons.link) — must exist on videos disk after upload.
     * Returns basename only, e.g. "1712345678_abc123.mp4"
     */
    function resolveStoredVideoFilename(mixed $value, string $folder = 'lessons'): ?string
    {
        $fileName = resolveUploadedFilename($value);

        if (! $fileName) {
            return null;
        }

        $fileName = basename($fileName);

        if (\App\Support\VideoStorage::exists($folder, $fileName)) {
            return $fileName;
        }

        if (is_file(\App\Support\VideoStorage::absolutePath($folder, $fileName))) {
            return $fileName;
        }

        return null;
    }
}

if (! function_exists('normalizeStoredFilename')) {
    /** One filename from DB (legacy comma-separated lists use first entry). */
    function normalizeStoredFilename(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = trim($value);
        if (str_contains($value, ',')) {
            $value = trim(explode(',', $value, 2)[0]);
        }

        return $value !== '' ? $value : null;
    }
}

if (! function_exists('websiteSectionIsVideo')) {
    function websiteSectionIsVideo(int|string $sectionId): bool
    {
        return in_array((int) $sectionId, [1, 5], true);
    }
}

if (! function_exists('websiteSectionAllowsMultipleImages')) {
    /** Sections #2, #3, #4 — swiper galleries. */
    function websiteSectionAllowsMultipleImages(int|string $sectionId): bool
    {
        return in_array((int) $sectionId, [2, 3, 4], true);
    }
}

if (! function_exists('websiteSectionVideoMaxFiles')) {
    function websiteSectionVideoMaxFiles(int|string $sectionId): int
    {
        return (int) $sectionId === 5 ? 2 : 1;
    }
}

if (! function_exists('implodeUploadedFilenamesMax')) {
    function implodeUploadedFilenamesMax(mixed $value, int $max): string
    {
        if (! is_array($value)) {
            $value = $value !== null && $value !== '' ? [$value] : [];
        }

        $names = [];
        foreach ($value as $item) {
            $item = is_string($item) ? trim($item) : '';
            if ($item === '') {
                continue;
            }
            $names[] = basename($item);
            if (count($names) >= $max) {
                break;
            }
        }

        return implode(',', array_values(array_unique($names)));
    }
}

if (! function_exists('explodeUploadedFilenames')) {
    /** Parse DB / form values into unique basenames (comma-separated or array). */
    function explodeUploadedFilenames(mixed $value): array
    {
        if (is_array($value)) {
            $names = [];
            foreach ($value as $item) {
                $item = is_string($item) ? trim($item) : '';
                if ($item !== '') {
                    $names[] = basename($item);
                }
            }

            return array_values(array_unique($names));
        }

        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        $names = [];
        foreach (explode(',', $value) as $item) {
            $item = trim($item);
            if ($item !== '') {
                $names[] = basename($item);
            }
        }

        return array_values(array_unique($names));
    }
}

if (! function_exists('implodeUploadedFilenames')) {
    /** Multiple Dropzone files (lesson images, PDFs, etc.) → comma-separated DB value. */
    function implodeUploadedFilenames(mixed $value): string
    {
        return implode(',', explodeUploadedFilenames($value));
    }
}

if (! function_exists('adminPaginationElements')) {
    /**
     * Build admin table page links: N pages before, M pages after current, with "..." gaps.
     *
     * @return array<int, array{page: int|null, url: string|null, ellipsis: bool}>
     */
    function adminPaginationElements(
        \Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator,
        ?int $pagesBefore = null,
        ?int $pagesAfter = null,
    ): array {
        $pagesBefore ??= (int) config('admin.pagination_pages_before', 3);
        $pagesAfter ??= (int) config('admin.pagination_pages_after', 2);

        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        $start = max(1, $current - $pagesBefore);
        $end = min($last, $current + $pagesAfter);

        $elements = [];

        if ($start > 1) {
            $elements[] = ['page' => 1, 'url' => $paginator->url(1), 'ellipsis' => false];
            if ($start > 2) {
                $elements[] = ['page' => null, 'url' => null, 'ellipsis' => true];
            }
        }

        for ($page = $start; $page <= $end; $page++) {
            if ($page === 1 && $start > 1) {
                continue;
            }
            if ($page === $last && $end < $last) {
                continue;
            }
            $elements[] = ['page' => $page, 'url' => $paginator->url($page), 'ellipsis' => false];
        }

        if ($end < $last) {
            if ($end < $last - 1) {
                $elements[] = ['page' => null, 'url' => null, 'ellipsis' => true];
            }
            $elements[] = ['page' => $last, 'url' => $paginator->url($last), 'ellipsis' => false];
        }

        return $elements;
    }
}

if (! function_exists('studentBarcodeImage')) {
    /**
     * Screen-only barcode for student check-in (dashboard/profile).
     * Same generation params as MakeCard — display size is controlled in CSS only.
     */
    function studentBarcodeImage(string $code): ?string
    {
        if (! class_exists('\DNS1D')) {
            return null;
        }

        return \DNS1D::getBarcodePNG($code, 'C128', 6, 160, [0, 0, 0], true);
    }
}
