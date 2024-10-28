<?php

declare(strict_types=1);

namespace App\Repositories\Category;

use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryContract
{
    /**
     * @var Category
     */
    protected $model = Category::class;
}
