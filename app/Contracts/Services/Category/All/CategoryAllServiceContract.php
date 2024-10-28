<?php

declare(strict_types=1);

namespace App\Contracts\Services\Category\All;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoryAllServiceContract
{
    public function handle(): LengthAwarePaginator;
}
