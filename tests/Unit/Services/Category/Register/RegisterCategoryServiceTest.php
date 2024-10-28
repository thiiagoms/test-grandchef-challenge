<?php

declare(strict_types=1);

use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\DTO\Category\Register\RegisterCategoryDTO;
use App\Models\Category;
use App\Services\Category\Register\RegisterCategoryService;

it('should return created category entity when provided category data is valid and created successfully', function (): void {

    $categoryDTO = RegisterCategoryDTO::fromArray([
        'name' => 'Test category name',
        'description' => 'Test category description',
    ]);

    $categoryMockEntity = new Category(['id' => fake()->uuid(), ...$categoryDTO->toArray()]);

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock->shouldReceive('create')
        ->once()
        ->with($categoryDTO->toArray())
        ->andReturn($categoryMockEntity);

    /** @var RegisterCategoryService $registerCategoryService */
    $registerCategoryService = resolve(RegisterCategoryService::class, ['categoryRepository' => $categoryRepositoryMock]);

    /** @var Category $category */
    $category = $registerCategoryService->handle($categoryDTO);

    expect($category)->toBeInstanceOf(Category::class);
    expect($category->id)->toBe($categoryMockEntity->id);
    expect($category->name)->toBe($categoryMockEntity->name);
    expect($category->description)->toBe($categoryMockEntity->description);

    Mockery::close();
});

it('should return created category entity when only category name is provided and created successfully', function (): void {

    $categoryDTO = RegisterCategoryDTO::fromArray([
        'name' => 'Test category name',
    ]);

    $categoryMockEntity = new Category(['id' => fake()->uuid(), ...$categoryDTO->toArray()]);

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock->shouldReceive('create')
        ->once()
        ->with($categoryDTO->toArray())
        ->andReturn($categoryMockEntity);

    /** @var RegisterCategoryService $registerCategoryService */
    $registerCategoryService = resolve(RegisterCategoryService::class, ['categoryRepository' => $categoryRepositoryMock]);

    /** @var Category $category */
    $category = $registerCategoryService->handle($categoryDTO);

    expect($category)
        ->toBeInstanceOf(Category::class)
        ->id->toBe($categoryMockEntity->id)
        ->name->toBe($categoryMockEntity->name)
        ->description->toBe($categoryMockEntity->description);

    Mockery::close();
});
