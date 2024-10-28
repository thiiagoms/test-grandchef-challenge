<?php

declare(strict_types=1);

use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use App\Models\Category;
use App\Services\Category\Find\FindCategoryByIdService;
use Pest\Expectation;

it('should throw invalid parameter exception with invalid parameter message when id provided is not a valid uuid',
    fn (): Expectation => expect(fn () => (resolve(FindCategoryByIdService::class))->handle('invalid-uuid'))
        ->toThrow(InvalidParameterException::class, SystemMessage::INVALID_PARAMETER)
);

it('should throw not found exception with resource not found message when id provided is a valid uuid but does not exists in database', function (): void {

    $categoryId = fake()->uuid();

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock->shouldReceive('find')
        ->once()
        ->with($categoryId)
        ->andReturnNull();

    /** @var FindCategoryByIdService $findCategoryByIdService */
    $findCategoryByIdService = resolve(FindCategoryByIdService::class, [
        'categoryRepository' => $categoryRepositoryMock,
    ]);

    expect(fn () => $findCategoryByIdService->handle($categoryId))
        ->toThrow(NotFoundException::class, SystemMessage::RESOURCE_NOT_FOUND);

    Mockery::close();
});

it('should return category entity when provided id is a valid uuid and exists in database', function (): void {

    $categoryId = fake()->uuid();

    $categoryMock = new Category([
        'id' => $categoryId,
        'name' => 'Category 1',
        'description' => 'Category 1 description',
    ]);

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock->shouldReceive('find')
        ->once()
        ->with($categoryId)
        ->andReturn($categoryMock);

    /** @var FindCategoryByIdService $findCategoryByIdService */
    $findCategoryByIdService = resolve(FindCategoryByIdService::class, [
        'categoryRepository' => $categoryRepositoryMock,
    ]);

    /** @var Category $category */
    $category = $findCategoryByIdService->handle($categoryId);

    expect($category)->toBeInstanceOf(Category::class);
    expect($category->id)->toBe($categoryId);
    expect($category->name)->toBe($categoryMock->name);
    expect($category->description)->toBe($categoryMock->description);

    Mockery::close();
});
