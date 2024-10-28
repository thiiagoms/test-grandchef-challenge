<?php

declare(strict_types=1);

use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;
use App\DTO\Product\Register\RegisterProductDTO;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use App\Models\Category;
use App\Models\Product;
use App\Services\Product\Register\RegisterProductService;

it('should throw invalid parameter exception with invalid parameter message when category id provided in RegisterProductDTO is not a valid uuid', function (): void {

    $registerProductDTO = RegisterProductDTO::fromArray([
        'category_id' => 'invalid-=name',
        'name' => 'Product 1',
        'price' => 3.65,
    ]);

    /** @var RegisterProductService $registerProductService */
    $registerProductService = resolve(RegisterProductService::class);

    expect(fn () => $registerProductService->handle($registerProductDTO))
        ->toThrow(InvalidParameterException::class, SystemMessage::INVALID_PARAMETER);
});

it('should throw not found exception with resource not found message when category id provided in RegisterProductDTO is a valid uuid but does not exists in database', function (): void {

    $registerProductDTO = RegisterProductDTO::fromArray([
        'category_id' => fake()->uuid(),
        'name' => 'Product 1',
        'price' => 3.65,
    ]);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($registerProductDTO->get('category_id'))
        ->andThrow(new NotFoundException(SystemMessage::RESOURCE_NOT_FOUND));

    /** @var RegisterProductService $registerProductService */
    $registerProductService = resolve(RegisterProductService::class, [
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
    ]);

    expect(fn () => $registerProductService->handle($registerProductDTO))
        ->toThrow(NotFoundException::class, SystemMessage::RESOURCE_NOT_FOUND);

    Mockery::close();
});

it('should return created product entity when provided product data is valid and created successfully', function (): void {

    $categoryMock = new Category([
        'id' => fake()->uuid(),
        'name' => 'Category 1',
        'description' => 'Category 1 description',
    ]);

    $registerProductDTO = RegisterProductDTO::fromArray([
        'category_id' => $categoryMock->id,
        'name' => 'Product 1',
        'price' => 3.65,
    ]);

    $productMockEntity = new Product(['id' => fake()->uuid(), ...$registerProductDTO->toArray()]);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($registerProductDTO->get('category_id'))
        ->andReturn($categoryMock);

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('create')
        ->once()
        ->with($registerProductDTO->toArray())
        ->andReturn($productMockEntity);

    /** @var RegisterProductService $registerProductService */
    $registerProductService = resolve(RegisterProductService::class, [
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'productRepository' => $productRepositoryMock,
    ]);

    $product = $registerProductService->handle($registerProductDTO);

    expect($product)
        ->toBeInstanceOf(Product::class)
        ->id->toBe($productMockEntity->id)
        ->category_id->toBe($productMockEntity->category_id)
        ->name->toBe($productMockEntity->name)
        ->price->toBe($productMockEntity->price);

    Mockery::close();
});
