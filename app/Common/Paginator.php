<?php

namespace App\Common;

use App\Contracts\Common\PaginatorContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Paginator implements PaginatorContract
{
    public function paginate(Collection $resource, int $resourcesPerPage = 10): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentPageItems = $resource->slice(($currentPage - 1) * $resourcesPerPage, $resourcesPerPage)->values();

        return new LengthAwarePaginator(
            $currentPageItems,
            $resource->count(),
            $resourcesPerPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }
}
