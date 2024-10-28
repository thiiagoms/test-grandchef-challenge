<?php

declare(strict_types=1);

use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use App\Models\Category;
use App\Models\Product;
use App\Services\Product\Find\FindProductByIdService;
use Pest\Expectation;

it('should throw invalid parameter exception with invalid parameter message when id provided is not a valid uuid',
    fn (): Expectation => expect(fn () => (resolve(FindProductByIdService::class))->handle('invalid-uuid'))
        ->toThrow(InvalidParameterException::class, SystemMessage::INVALID_PARAMETER)
);

it('should throw not found exception with resource not found message when id provided is a valid uuid but does not exists in database', function (): void {

    $productId = fake()->uuid();

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('find')
        ->once()
        ->with($productId)
        ->andReturnNull();

    /** @var FindProductByIdService $findProductByIdService */
    $findProductByIdService = resolve(FindProductByIdService::class, [
        'productRepository' => $productRepositoryMock,
    ]);

    expect(fn () => $findProductByIdService->handle($productId))
        ->toThrow(NotFoundException::class, SystemMessage::RESOURCE_NOT_FOUND);

    Mockery::close();
});

it('should return product entity when provided id is a valid uuid and exists in database', function (): void {

    $productId = fake()->uuid();

    $productMock = new Product([
        'id' => $productId,
        'category_id' => new Category([
            'id' => fake()->uuid(),
            'name' => 'Category 1',
            'description' => 'Category 1 description',
        ]),
        'name' => 'Product 1',
        'price' => 3.50,
    ]);

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('find')
        ->once()
        ->with($productId)
        ->andReturn($productMock);

    /** @var FindProductByIdService $findProductByIdService */
    $findProductByIdService = resolve(FindProductByIdService::class, [
        'productRepository' => $productRepositoryMock,
    ]);

    expect($findProductByIdService->handle($productId))
        ->toBe($productMock);

    Mockery::close();
});
