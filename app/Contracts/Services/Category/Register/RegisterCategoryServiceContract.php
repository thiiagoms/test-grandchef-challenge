<?php

declare(strict_types=1);

namespace App\Contracts\Services\Category\Register;

use App\Contracts\DTO\Category\Register\RegisterCategoryDTOContract;
use App\Models\Category;

interface RegisterCategoryServiceContract
{
    public function handle(RegisterCategoryDTOContract $categoryDTO): Category;
}
