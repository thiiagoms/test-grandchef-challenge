<?php

declare(strict_types=1);

namespace App\Contracts\Common;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface PaginatorContract
{
    public function paginate(Collection $resources, int $resourcesPerPage = 10): LengthAwarePaginator;
}
