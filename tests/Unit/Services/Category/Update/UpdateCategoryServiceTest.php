<?php

declare(strict_types=1);

use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;
use App\DTO\Category\Update\UpdateCategoryDTO;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use App\Models\Category;
use App\Services\Category\Update\UpdateCategoryService;
use Pest\Expectation;

it('should throw invalid parameter exception with invalid parameter message when id provided in UpdateCategoryDTO is not a valid uuid',
    fn (): Expectation => expect(fn () => (resolve(UpdateCategoryService::class))
        ->handle(UpdateCategoryDTO::fromArray(['id' => fake()->name()]))
    )->toThrow(InvalidParameterException::class, SystemMessage::INVALID_PARAMETER)
);

it('should throw not found exception with resource not found message when id provided in UpdateCategoryDTO is a valid uuid but does not exists in database', function (): void {

    $categoryUpdateDTO = UpdateCategoryDTO::fromArray(['id' => fake()->uuid()]);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($categoryUpdateDTO->get('id'))
        ->andThrow(new NotFoundException(SystemMessage::RESOURCE_NOT_FOUND));

    /** @var UpdateCategoryService $updateCategoryService */
    $updateCategoryService = resolve(UpdateCategoryService::class, [
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
    ]);

    expect(fn () => $updateCategoryService->handle($categoryUpdateDTO))
        ->toThrow(NotFoundException::class, SystemMessage::RESOURCE_NOT_FOUND);

    Mockery::close();
});

it('should update only category name in database when id provided is valid uuid on UpdateCategoryDTO and when only category name is provided', function (): void {

    $categoryId = fake()->uuid();

    $categoryMock = new Category(['id' => $categoryId, 'name' => 'Category name 1']);

    $categoryUpdateDTO = UpdateCategoryDTO::fromArray(['id' => $categoryId, 'name' => 'Category name 2']);

    $categoryUpdatedMock = new Category(['id' => $categoryId, 'name' => $categoryUpdateDTO->get('name')]);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->twice()
        ->with($categoryUpdateDTO->get('id'))
        ->andReturnUsing(fn (): Category => $categoryMock, fn (): Category => $categoryUpdatedMock);

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock->shouldReceive('update')
        ->once()
        ->with($categoryMock->id, removeEmpty($categoryUpdateDTO->toArray()))
        ->andReturnTrue();

    /** @var UpdateCategoryService $updateCategoryService */
    $updateCategoryService = resolve(UpdateCategoryService::class, [
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'categoryRepository' => $categoryRepositoryMock,
    ]);

    /** @var Category $category */
    $category = $updateCategoryService->handle($categoryUpdateDTO);

    expect($category)
        ->toBeInstanceOf(Category::class)
        ->id->toBe($categoryMock->id)
        ->name->toBe($categoryUpdateDTO->get('name'))
        ->name->not->toBe($categoryMock->name)
        ->description->toBe($categoryMock->description);

    Mockery::close();
});

it('should update only category description in database when id provided is valid uuid on UpdateCategoryDTO and when only category description is provided', function (): void {

    $categoryId = fake()->uuid();

    $categoryMock = new Category(['id' => $categoryId, 'description' => 'Description Category 1']);

    $categoryUpdateDTO = UpdateCategoryDTO::fromArray(['id' => $categoryId, 'description' => 'Description Category 2']);

    $categoryUpdatedMock = new Category(['id' => $categoryId, 'description' => 'Description Category 2']);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->twice()
        ->with($categoryUpdateDTO->get('id'))
        ->andReturnUsing(fn (): Category => $categoryMock, fn (): Category => $categoryUpdatedMock);

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock->shouldReceive('update')
        ->once()
        ->with($categoryMock->id, removeEmpty($categoryUpdateDTO->toArray()))
        ->andReturnTrue();

    /** @var UpdateCategoryService $updateCategoryService */
    $updateCategoryService = resolve(UpdateCategoryService::class, [
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'categoryRepository' => $categoryRepositoryMock,
    ]);

    /** @var Category $category */
    $category = $updateCategoryService->handle($categoryUpdateDTO);

    expect($category)
        ->toBeInstanceOf(Category::class)
        ->id->toBe($categoryMock->id)
        ->description->toBe($categoryUpdateDTO->get('description'))
        ->description->not->toBe($categoryMock->description)
        ->name->toBe($categoryMock->name);

    Mockery::close();
});

it('should update category name and description in database when id provided is valid uuid on UpdateCategoryDTO and when category name and description are provided', function (): void {

    $categoryId = fake()->uuid();

    $categoryMock = new Category(['id' => $categoryId, 'name' => 'Category name 1', 'description' => 'Description Category 1']);

    $categoryUpdateDTO = UpdateCategoryDTO::fromArray(['id' => $categoryId, 'name' => 'Category name 2', 'description' => 'Description Category 2']);

    $categoryUpdatedMock = new Category(['id' => $categoryId, 'name' => 'Category name 2', 'description' => 'Description Category 2']);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->twice()
        ->with($categoryUpdateDTO->get('id'))
        ->andReturnUsing(fn (): Category => $categoryMock, fn (): Category => $categoryUpdatedMock);

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock->shouldReceive('update')
        ->once()
        ->with($categoryMock->id, removeEmpty($categoryUpdateDTO->toArray()))
        ->andReturnTrue();

    /** @var UpdateCategoryService $updateCategoryService */
    $updateCategoryService = resolve(UpdateCategoryService::class, [
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'categoryRepository' => $categoryRepositoryMock,
    ]);

    /** @var Category $category */
    $category = $updateCategoryService->handle($categoryUpdateDTO);

    expect($category)
        ->toBeInstanceOf(Category::class)
        ->id->toBe($categoryMock->id)
        ->name->toBe($categoryUpdateDTO->get('name'))
        ->name->not->toBe($categoryMock->name)
        ->description->toBe($categoryUpdateDTO->get('description'))
        ->description->not->toBe($categoryMock->description);

    Mockery::close();
});

it('should update nothing in database when id provided is valid uuid on UpdateCategoryDTO but does not exists category name and description values in UpdateCategoryDTO', function (): void {

    $categoryId = fake()->uuid();

    $categoryMock = new Category(['id' => $categoryId, 'name' => 'Category name 1', 'description' => 'Description Category 1']);

    $categoryUpdateDTO = UpdateCategoryDTO::fromArray(['id' => $categoryId]);

    $categoryUpdatedMock = new Category(['id' => $categoryId, 'name' => 'Category name 1', 'description' => 'Description Category 1']);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->twice()
        ->with($categoryUpdateDTO->get('id'))
        ->andReturnUsing(fn (): Category => $categoryMock, fn (): Category => $categoryUpdatedMock);

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock->shouldReceive('update')
        ->once()
        ->with($categoryMock->id, removeEmpty($categoryUpdateDTO->toArray()))
        ->andReturnTrue();

    /** @var UpdateCategoryService $updateCategoryService */
    $updateCategoryService = resolve(UpdateCategoryService::class, [
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'categoryRepository' => $categoryRepositoryMock,
    ]);

    /** @var Category $category */
    $category = $updateCategoryService->handle($categoryUpdateDTO);

    expect($category)
        ->toBeInstanceOf(Category::class)
        ->id->toBe($categoryMock->id)
        ->name->toBe($categoryMock->name)
        ->description->toBe($categoryMock->description);

    Mockery::close();
});
