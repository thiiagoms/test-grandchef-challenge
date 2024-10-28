<?php

use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Contracts\Services\Product\Find\FindProductByIdServiceContract;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use App\Models\Product;
use App\Services\Product\Destroy\DestroyProductService;
use Pest\Expectation;

it('should throw invalid parameter exception with invalid parameter message when id provided is not a valid uuid',
    fn (): Expectation => expect(fn () => (resolve(DestroyProductService::class))->handle('invalid-uuid'))
        ->toThrow(InvalidParameterException::class, SystemMessage::INVALID_PARAMETER)
);

it('should throw not found exception with resource not found message when id provided is a valid uuid but does not exists in database', function (): void {

    $productId = fake()->uuid();

    $findProductByIdServiceMock = Mockery::mock(FindProductByIdServiceContract::class);

    $findProductByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($productId)
        ->andThrow(new NotFoundException(SystemMessage::RESOURCE_NOT_FOUND));

    /** @var DestroyProductService $destroyProductService */
    $destroyProductService = resolve(DestroyProductService::class, [
        'findProductByIdService' => $findProductByIdServiceMock,
    ]);

    expect(fn () => $destroyProductService->handle($productId))
        ->toThrow(NotFoundException::class, SystemMessage::RESOURCE_NOT_FOUND);

    Mockery::close();
});

it('should destroy product when id provided is a valid uuid and exists in database', function (): void {

    $productId = fake()->uuid();

    $productMock = new Product(['id' => $productId, 'name' => 'Product 1', 'price' => 3.50]);

    $findProductByIdServiceMock = Mockery::mock(FindProductByIdServiceContract::class);

    $findProductByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($productId)
        ->andReturn($productMock);

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('destroy')
        ->once()
        ->with($productId)
        ->andReturnTrue();

    /** @var DestroyProductService $destroyProductService */
    $destroyProductService = resolve(DestroyProductService::class, [
        'findProductByIdService' => $findProductByIdServiceMock,
        'productRepository' => $productRepositoryMock,
    ]);

    expect($destroyProductService->handle($productId))
        ->toBeTrue();

    Mockery::close();
});
