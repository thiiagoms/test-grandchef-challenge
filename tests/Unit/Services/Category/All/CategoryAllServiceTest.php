<?php

declare(strict_types=1);

use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Models\Category;
use App\Services\Category\All\CategoryAllService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

it('should return paginate categories collection when exists categories in database with 10 itens per page', function (): void {

    $categories = new Collection([
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 1', 'description' => 'Category description 1']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 2', 'description' => 'Category description 2']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 3', 'description' => 'Category description 3']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 4', 'description' => 'Category description 4']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 5', 'description' => 'Category description 5']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 6', 'description' => 'Category description 6']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 7', 'description' => 'Category description 7']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 8', 'description' => 'Category description 8']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 9', 'description' => 'Category description 9']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 10', 'description' => 'Category description 10']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 11', 'description' => 'Category description 11']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 12', 'description' => 'Category description 12']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 13', 'description' => 'Category description 13']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 14', 'description' => 'Category description 14']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 15', 'description' => 'Category description 15']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 16', 'description' => 'Category description 16']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 17', 'description' => 'Category description 17']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 18', 'description' => 'Category description 18']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 19', 'description' => 'Category description 19']),
        new Category(['id' => fake()->uuid(), 'name' => 'Category name 20', 'description' => 'Category description 20']),
    ]);

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock
        ->shouldReceive('all')
        ->once()
        ->andReturn($categories);

    /** @var CategoryAllService $categoryAllService */
    $categoryAllService = resolve(CategoryAllService::class, [
        'categoryRepository' => $categoryRepositoryMock,
    ]);

    $categoriesPaginated = $categoryAllService->handle();

    expect($categoriesPaginated)
        ->toBeInstanceOf(LengthAwarePaginator::class)
        ->toHaveCount(10);

    Mockery::close();
});

it('should return empty categories collection when does not exists categories in database', function (): void {

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock
        ->shouldReceive('all')
        ->once()
        ->andReturn(new Collection);

    /** @var CategoryAllService $categoryAllService */
    $categoryAllService = resolve(CategoryAllService::class, [
        'categoryRepository' => $categoryRepositoryMock,
    ]);

    $categoriesPaginated = $categoryAllService->handle();

    expect($categoriesPaginated)
        ->toBeInstanceOf(LengthAwarePaginator::class)
        ->toHaveCount(0);

    Mockery::close();
});
