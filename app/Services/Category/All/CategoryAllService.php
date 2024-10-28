<?php

declare(strict_types=1);

namespace App\Services\Category\All;

use App\Contracts\Common\PaginatorContract;
use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Contracts\Services\Category\All\CategoryAllServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryAllService implements CategoryAllServiceContract
{
    public function __construct(
        private readonly CategoryRepositoryContract $categoryRepository,
        private readonly PaginatorContract $paginator
    ) {}

    public function handle(): LengthAwarePaginator
    {
        $categories = $this->categoryRepository->all();

        return $this->paginator->paginate($categories);
    }
}
