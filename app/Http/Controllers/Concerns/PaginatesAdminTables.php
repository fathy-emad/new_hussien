<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait PaginatesAdminTables
{
    protected function adminPerPage(Request $request): int
    {
        $perPage = (int) $request->input('per_page', config('admin.per_page', 10));
        $allowed = config('admin.per_page_options', [5, 10, 15, 25, 50]);

        return in_array($perPage, $allowed, true)
            ? $perPage
            : (int) config('admin.per_page', 10);
    }

    /**
     * @template T of \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     *
     * @param  T  $query
     */
    protected function paginateAdminTable($query, Request $request): LengthAwarePaginator
    {
        return $query
            ->paginate($this->adminPerPage($request))
            ->withQueryString();
    }
}
