<?php

declare(strict_types=1);

use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Models\Product;
use App\Services\Product\All\ProductAllService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

it('should return paginate products collection when exists products in database with 10 itens per page', function (): void {

    $products = new Collection([
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 1', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 2', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 3', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 4', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 5', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 6', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 7', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 8', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 9', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 10', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 11', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 12', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 13', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 14', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 15', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 16', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 17', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 18', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 19', 'price' => 3.50]),
        new Product(['id' => fake()->uuid(), 'category_id' => fake()->uuid(), 'name' => 'Product 20', 'price' => 3.50]),
    ]);

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('all')
        ->once()
        ->andReturn($products);

    /** @var ProductAllService $productAllService */
    $productAllService = resolve(ProductAllService::class, ['productRepository' => $productRepositoryMock]);

    expect($productAllService->handle())
        ->toBeInstanceOf(LengthAwarePaginator::class)
        ->toHaveCount(10);

    Mockery::close();
});

it('should return empty products collection when does not exists products in database', function (): void {

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('all')
        ->once()
        ->andReturn(new Collection);

    /** @var ProductAllService $productAllService */
    $productAllService = resolve(ProductAllService::class, ['productRepository' => $productRepositoryMock]);

    expect($productAllService->handle())
        ->toBeInstanceOf(LengthAwarePaginator::class)
        ->toHaveCount(0);

    Mockery::close();
});
