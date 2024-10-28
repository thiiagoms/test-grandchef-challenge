<?php

declare(strict_types=1);

use App\Contracts\Repositories\Product\ProductRepositoryContract;
use App\Contracts\Services\Category\Find\FindCategoryByIdServiceContract;
use App\Contracts\Services\Product\Find\FindProductByIdServiceContract;
use App\DTO\Product\Update\UpdateProductDTO;
use App\Exceptions\InvalidParameterException;
use App\Exceptions\NotFoundException;
use App\Messages\System\SystemMessage;
use App\Models\Category;
use App\Models\Product;
use App\Services\Product\Update\UpdateProductService;

it('should throw invalid parameter exception with invalid parameter message when product id provided in UpdateProductDTO is not a valid uuid', function (): void {

    $updateProductDTO = UpdateProductDTO::fromArray(['id' => 'invalid-product-id', 'category_id' => fake()->uuid()]);

    /** @var UpdateProductService $updateProductService */
    $updateProductService = resolve(UpdateProductService::class);

    expect(fn () => $updateProductService->handle($updateProductDTO))
        ->toThrow(InvalidParameterException::class, SystemMessage::INVALID_PARAMETER);
});

it('should throw not found exception with resource not found message when product id provided in UpdateProductDTO is a valid uuid but does not exists in database', function (): void {

    $updateProductDTO = UpdateProductDTO::fromArray(['id' => fake()->uuid(), 'category_id' => fake()->uuid()]);

    $findProductByIdServiceMock = Mockery::mock(FindProductByIdServiceContract::class);

    $findProductByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($updateProductDTO->get('id'))
        ->andThrow(new NotFoundException(SystemMessage::RESOURCE_NOT_FOUND));

    /** @var UpdateProductService $updateProductService */
    $updateProductService = resolve(UpdateProductService::class, [
        'findProductByIdService' => $findProductByIdServiceMock,
    ]);

    expect(fn () => $updateProductService->handle($updateProductDTO))
        ->toThrow(NotFoundException::class, SystemMessage::RESOURCE_NOT_FOUND);

    Mockery::close();
});

it('should throw invalid parameter exception with invalid parameter message when category id provided in UpdateProductDTO is not a valid uuid', function (): void {

    $productMockId = fake()->uuid();

    $productMock = new Product([
        'id' => $productMockId,
        'category_id' => new Category([
            'id' => fake()->uuid(),
            'name' => 'Category 1',
            'description' => 'Category 1 description',
        ]),
        'name' => 'Product 1',
        'price' => 3.50,
    ]);

    $updateProductDTO = UpdateProductDTO::fromArray(['id' => $productMockId, 'category_id' => 'invalid-category-id']);

    $findProductByIdServiceMock = Mockery::mock(FindProductByIdServiceContract::class);

    $findProductByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($updateProductDTO->get('id'))
        ->andReturn($productMock);

    /** @var UpdateProductService $updateProductService */
    $updateProductService = resolve(UpdateProductService::class, [
        'findProductByIdService' => $findProductByIdServiceMock,
    ]);

    expect(fn () => $updateProductService->handle($updateProductDTO))
        ->toThrow(InvalidParameterException::class, SystemMessage::INVALID_PARAMETER);

    Mockery::close();
});

it('should throw not found exception with resource not found message when category id provided in UpdateProductDTO is a valid uuid but does not exists in database', function (): void {

    $productMockId = fake()->uuid();

    $categoryMockId = fake()->uuid();

    $productMock = new Product([
        'id' => $productMockId,
        'category_id' => new Category([
            'id' => $categoryMockId,
            'name' => 'Category 1',
            'description' => 'Category 1 description',
        ]),
        'name' => 'Product 1',
        'price' => 3.50,
    ]);

    $updateProductDTO = UpdateProductDTO::fromArray(['id' => $productMockId, 'category_id' => $categoryMockId]);

    $findProductByIdServiceMock = Mockery::mock(FindProductByIdServiceContract::class);

    $findProductByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($updateProductDTO->get('id'))
        ->andReturn($productMock);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($updateProductDTO->get('category_id'))
        ->andThrow(new NotFoundException(SystemMessage::RESOURCE_NOT_FOUND));

    /** @var UpdateProductService $updateProductService */
    $updateProductService = resolve(UpdateProductService::class, [
        'findProductByIdService' => $findProductByIdServiceMock,
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
    ]);

    expect(fn () => $updateProductService->handle($updateProductDTO))
        ->toThrow(NotFoundException::class, SystemMessage::RESOURCE_NOT_FOUND);

    Mockery::close();
});

it('should update only category id in database when only category id is provided and it is a valid category', function (): void {

    $productMockId = fake()->uuid();

    $categoryMockId = fake()->uuid();

    $categoryMock = new Category([
        'id' => fake()->uuid(),
        'name' => 'Category 1',
        'description' => 'Category 1 description',
    ]);

    $productMock = new Product([
        'id' => $productMockId,
        'category_id' => $categoryMock->id,
        'name' => 'Product 1',
        'price' => 3.50,
    ]);

    $productMock->setRelation('category', $categoryMock);

    $categoryToBeUpdatedMock = new Category([
        'id' => $categoryMockId,
        'name' => 'Category 2',
        'description' => 'Category 2 description',
    ]);

    $productUpdatedMock = new Product([
        'id' => $productMockId,
        'category_id' => $categoryToBeUpdatedMock->id,
        'name' => 'Product 1',
        'price' => 3.50,
    ]);

    $productUpdatedMock->setRelation('category', $categoryToBeUpdatedMock);

    $updateProductDTO = UpdateProductDTO::fromArray([
        'id' => $productMockId,
        'category_id' => $categoryToBeUpdatedMock->id,
    ]);

    $findProductByIdServiceMock = Mockery::mock(FindProductByIdServiceContract::class);

    $findProductByIdServiceMock->shouldReceive('handle')
        ->twice()
        ->with($updateProductDTO->get('id'))
        ->andReturnUsing(fn (): Product => $productMock, fn (): Product => $productUpdatedMock);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($updateProductDTO->get('category_id'))
        ->andReturn($categoryToBeUpdatedMock);

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('update')
        ->once()
        ->with($updateProductDTO->get('id'), removeEmpty($updateProductDTO->toArray()))
        ->andReturnTrue();

    /** @var UpdateProductService $updateProductService */
    $updateProductService = resolve(UpdateProductService::class, [
        'findProductByIdService' => $findProductByIdServiceMock,
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'productRepository' => $productRepositoryMock,
    ]);

    /** @var Product $product */
    $product = $updateProductService->handle($updateProductDTO);

    expect($product)
        ->toBeInstanceOf(Product::class)
        ->id->toBe($productMock->id)
        ->name->toBe($productMock->name)
        ->price->toBe($productMock->price)
        ->category->id->toBe($productUpdatedMock->category->id)
        ->category->name->toBe($productUpdatedMock->category->name)
        ->category->description->toBe($productUpdatedMock->category->description);

    Mockery::close();
});

it('should update only product name in database when only product name is provided ahd return updated product entity', function (): void {

    $productMockId = fake()->uuid();

    $categoryMockId = fake()->uuid();

    $categoryMock = new Category([
        'id' => $categoryMockId,
        'name' => 'Category 1',
        'description' => 'Category 1 description',
    ]);

    $productMock = new Product([
        'id' => $productMockId,
        'category_id' => $categoryMock->id,
        'name' => 'Product 1',
        'price' => 3.50,
    ]);

    $productMock->setRelation('category', $categoryMock);

    $productUpdatedMock = new Product([
        'id' => $productMockId,
        'category_id' => $categoryMock->id,
        'name' => 'Product 2',
        'price' => 3.50,
    ]);

    $productUpdatedMock->setRelation('category', $categoryMock);

    $updateProductDTO = UpdateProductDTO::fromArray([
        'id' => $productMockId,
        'category_id' => $categoryMockId,
        'name' => 'Product 2',
    ]);

    $findProductByIdServiceMock = Mockery::mock(FindProductByIdServiceContract::class);

    $findProductByIdServiceMock->shouldReceive('handle')
        ->twice()
        ->with($updateProductDTO->get('id'))
        ->andReturnUsing(fn (): Product => $productMock, fn (): Product => $productUpdatedMock);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($updateProductDTO->get('category_id'))
        ->andReturn($categoryMock);

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('update')
        ->once()
        ->with($updateProductDTO->get('id'), removeEmpty($updateProductDTO->toArray()))
        ->andReturnTrue();

    /** @var UpdateProductService $updateProductService */
    $updateProductService = resolve(UpdateProductService::class, [
        'findProductByIdService' => $findProductByIdServiceMock,
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'productRepository' => $productRepositoryMock,
    ]);

    /** @var Product $product */
    $product = $updateProductService->handle($updateProductDTO);

    expect($product)
        ->toBeInstanceOf(Product::class)
        ->id->toBe($productMock->id)
        ->name->toBe($productUpdatedMock->name)
        ->price->toBe($productMock->price)
        ->category->id->toBe($productMock->category->id)
        ->category->name->toBe($productMock->category->name)
        ->category->description->toBe($productMock->category->description)
        ->name->not->toBe($productMock->name);

    Mockery::close();
});

it('should update only product price in database when only product price is provided and return updated product entity', function (): void {

    $productMockId = fake()->uuid();

    $categoryMockId = fake()->uuid();

    $categoryMock = new Category([
        'id' => $categoryMockId,
        'name' => 'Category 1',
        'description' => 'Category 1 description',
    ]);

    $productMock = new Product([
        'id' => $productMockId,
        'category_id' => $categoryMock->id,
        'name' => 'Product 1',
        'price' => 3.50,
    ]);

    $productMock->setRelation('category', $categoryMock);

    $productUpdatedMock = new Product([
        'id' => $productMockId,
        'category_id' => $categoryMock->id,
        'name' => 'Product 1',
        'price' => 4.50,
    ]);

    $productUpdatedMock->setRelation('category', $categoryMock);

    $updateProductDTO = UpdateProductDTO::fromArray([
        'id' => $productMockId,
        'category_id' => $categoryMockId,
        'price' => 4.50,
    ]);

    $findProductByIdServiceMock = Mockery::mock(FindProductByIdServiceContract::class);

    $findProductByIdServiceMock->shouldReceive('handle')
        ->twice()
        ->with($updateProductDTO->get('id'))
        ->andReturnUsing(fn (): Product => $productMock, fn (): Product => $productUpdatedMock);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($updateProductDTO->get('category_id'))
        ->andReturn($categoryMock);

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('update')
        ->once()
        ->with($updateProductDTO->get('id'), removeEmpty($updateProductDTO->toArray()))
        ->andReturnTrue();

    /** @var UpdateProductService $updateProductService */
    $updateProductService = resolve(UpdateProductService::class, [
        'findProductByIdService' => $findProductByIdServiceMock,
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'productRepository' => $productRepositoryMock,
    ]);

    /** @var Product $product */
    $product = $updateProductService->handle($updateProductDTO);

    expect($product)
        ->toBeInstanceOf(Product::class)
        ->id->toBe($productMock->id)
        ->name->toBe($productMock->name)
        ->price->toBe($productUpdatedMock->price)
        ->category->id->toBe($productMock->category->id)
        ->category->name->toBe($productMock->category->name)
        ->category->description->toBe($productMock->category->description)
        ->price->not->toBe($productMock->name);

    Mockery::close();
});

it('should update entire product entity when entire product data is provided and return update product entity', function (): void {

    $productMockId = fake()->uuid();

    $categoryMockId = fake()->uuid();

    $categoryMock = new Category([
        'id' => $categoryMockId,
        'name' => 'Category 1',
        'description' => 'Category 1 description',
    ]);

    $productMock = new Product([
        'id' => $productMockId,
        'category_id' => $categoryMock->id,
        'name' => 'Product 1',
        'price' => 3.50,
    ]);

    $productMock->setRelation('category', $categoryMock);

    $categoryToBeUpdatedMock = new Category([
        'id' => $categoryMockId,
        'name' => 'Category 2',
        'description' => 'Category 2 description',
    ]);

    $productUpdatedMock = new Product([
        'id' => $productMockId,
        'category_id' => $categoryToBeUpdatedMock->id,
        'name' => 'Product 2',
        'price' => 4.50,
    ]);

    $productUpdatedMock->setRelation('category', $categoryToBeUpdatedMock);

    $updateProductDTO = UpdateProductDTO::fromArray([
        'id' => $productMockId,
        'category_id' => $categoryToBeUpdatedMock->id,
        'name' => 'Product 2',
        'price' => 4.50,
    ]);

    $findProductByIdServiceMock = Mockery::mock(FindProductByIdServiceContract::class);

    $findProductByIdServiceMock->shouldReceive('handle')
        ->twice()
        ->with($updateProductDTO->get('id'))
        ->andReturnUsing(fn (): Product => $productMock, fn (): Product => $productUpdatedMock);

    $findCategoryByIdServiceMock = Mockery::mock(FindCategoryByIdServiceContract::class);

    $findCategoryByIdServiceMock->shouldReceive('handle')
        ->once()
        ->with($updateProductDTO->get('category_id'))
        ->andReturn($categoryToBeUpdatedMock);

    $productRepositoryMock = Mockery::mock(ProductRepositoryContract::class);

    $productRepositoryMock->shouldReceive('update')
        ->once()
        ->with($updateProductDTO->get('id'), removeEmpty($updateProductDTO->toArray()))
        ->andReturnTrue();

    /** @var UpdateProductService $updateProductService */
    $updateProductService = resolve(UpdateProductService::class, [
        'findProductByIdService' => $findProductByIdServiceMock,
        'findCategoryByIdService' => $findCategoryByIdServiceMock,
        'productRepository' => $productRepositoryMock,
    ]);

    /** @var Product $product */
    $product = $updateProductService->handle($updateProductDTO);

    expect($product)
        ->toBeInstanceOf(Product::class)
        ->id->toBe($productUpdatedMock->id)
        ->name->toBe($productUpdatedMock->name)
        ->price->toBe($productUpdatedMock->price)
        ->category->id->toBe($productUpdatedMock->category->id)
        ->category->name->toBe($productUpdatedMock->category->name)
        ->category->description->toBe($productUpdatedMock->category->description)
        ->name->not->toBe($productMock->name)
        ->price->not->toBe($productMock->price)
        ->category->name->not->toBe($productMock->category->name)
        ->category->description->not->toBe($productMock->category->description);

    Mockery::close();
});
