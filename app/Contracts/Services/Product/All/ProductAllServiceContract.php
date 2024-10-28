<?php

declare(strict_types=1);

namespace App\Contracts\Services\Product\All;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductAllServiceContract
{
    public function handle(): LengthAwarePaginator;
}
