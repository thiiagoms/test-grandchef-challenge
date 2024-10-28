<?php

declare(strict_types=1);

use App\Contracts\Repositories\Category\CategoryRepositoryContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use App\Models\Category;
use App\Services\Category\Destroy\DestroyCategoryService;
use Pest\Expectation;

it('should throw invalid parameter exception with invalid parameter message when id provided is not a valid uuid',
    fn (): Expectation => expect(fn () => (resolve(DestroyCategoryService::class))->handle('invalid-uuid'))
        ->toThrow(InvalidParameterException::class, SystemMessage::INVALID_PARAMETER)
);

it('should throw not found exception with resource not found message when id provided is a valid uuid but does not exists in database', function (): void {

    $categoryId = fake()->uuid();

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($categoryId)
        ->andThrow(new NotFoundException(SystemMessage::RESOURCE_NOT_FOUND));

    /** @var DestroyCategoryService $destroyCategoryService */
    $destroyCategoryService = resolve(DestroyCategoryService::class, [
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
    ]);

    expect(fn () => $destroyCategoryService->handle($categoryId))
        ->toThrow(NotFoundException::class, SystemMessage::RESOURCE_NOT_FOUND);

    Mockery::close();
});

it('should return true when category id provided is a valid uuid and exists in database', function (): void {

    $categoryId = fake()->uuid();

    $categoryMock = new Category(['id' => $categoryId]);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($categoryId)
        ->andReturn($categoryMock);

    $categoryRepositoryMock = Mockery::mock(CategoryRepositoryContract::class);

    $categoryRepositoryMock->shouldReceive('destroy')
        ->once()
        ->with($categoryId)
        ->andReturnTrue();

    /** @var DestroyCategoryService $destroyCategoryService */
    $destroyCategoryService = resolve(DestroyCategoryService::class, [
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'categoryRepository' => $categoryRepositoryMock,
    ]);

    expect($destroyCategoryService->handle($categoryId))
        ->toBeTrue();

    Mockery::close();
});
