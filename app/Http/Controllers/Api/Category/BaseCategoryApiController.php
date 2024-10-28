<?php

namespace App\Http\Controllers\Api\Category;

use App\Contracts\Services\Category\All\CategoryAllServiceContract;
use App\Contracts\Services\Category\Destroy\DestroyCategoryServiceContract;
use App\Contracts\Services\Category\Register\RegisterCategoryServiceContract;
use App\Contracts\Services\Category\Update\UpdateCategoryServiceContract;
use App\Http\Controllers\Controller;

abstract class BaseCategoryApiController extends Controller
{
    public function __construct(
        protected readonly RegisterCategoryServiceContract $registerCategoryService,
        protected readonly UpdateCategoryServiceContract $updateCategoryService,
        protected readonly DestroyCategoryServiceContract $destroyCategoryService,
        protected readonly CategoryAllServiceContract $categoryAllService
    ) {}
}
