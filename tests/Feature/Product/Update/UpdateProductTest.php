<?php

declare(strict_types=1);

use App\Messages\Product\ProductCategoryMessage;
use App\Messages\Product\ProductNameMessage;
use App\Messages\Product\ProductPriceMessage;
use App\Messages\System\SystemMessage;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

beforeEach(fn (): Product => $this->product = Product::factory()->createOne());

it('should return resource not found message when product id is not a valid uuid', fn (): TestResponse => $this
    ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.'invalid-uuid', [])
    ->assertNotFound()
    ->assertJson(
        fn (AssertableJson $json): AssertableJson => $json
            ->has('message')
            ->whereType('message', 'string')
            ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
    )
);

it('should return resource not found message when product id is valid uuid but does not exists in database',
    fn (): TestResponse => $this
        ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.'invalid-uuid', [])
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        )
);

it('should return category id field is required message when category name field is empty', fn (): TestResponse => $this
    ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, ['category_id' => ''])
    ->assertBadRequest()
    ->assertJson(fn (AssertableJson $json): AssertableJson => $json
        ->hasAll([
            'error',
            'error.category_id',
            'error.category_id.0',
        ])
        ->whereAllType([
            'error' => 'array',
            'error.category_id' => 'array',
            'error.category_id.0' => 'string',
        ])
        ->where('error.category_id.0', ProductCategoryMessage::PRODUCT_CATEGORY_ID_IS_REQUIRED)
    )
);

it('should return category id field must be a valid uuid message when category id field is not a valid uuid',
    fn (): TestResponse => $this
        ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, ['category_id' => 'invalid-ID'])
        ->assertBadRequest()
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json
            ->hasAll([
                'error',
                'error.category_id',
                'error.category_id.0',
            ])
            ->whereAllType([
                'error' => 'array',
                'error.category_id' => 'array',
                'error.category_id.0' => 'string',
            ])
            ->where('error.category_id.0', ProductCategoryMessage::PRODUCT_CATEGORY_ID_MUST_BE_A_VALID_ID)
        )
);

it('should return category id does not exist message when category id is a valid uuid but does not exist in database',
    fn (): TestResponse => $this
        ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, ['category_id' => fake()->uuid()])
        ->assertBadRequest()
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json
            ->hasAll([
                'error',
                'error.category_id',
                'error.category_id.0',
            ])
            ->whereAllType([
                'error' => 'array',
                'error.category_id' => 'array',
                'error.category_id.0' => 'string',
            ])
            ->where('error.category_id.0', ProductCategoryMessage::PRODUCT_CATEGORY_ID_DOES_NOT_EXIST)
        )
);

it('should return product name must be a string message when product name field is not a string', fn (): TestResponse => $this
    ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, ['name' => 123])
    ->assertBadRequest()
    ->assertJson(fn (AssertableJson $json): AssertableJson => $json
        ->hasAll([
            'error',
            'error.name',
            'error.name.0',
        ])
        ->whereAllType([
            'error' => 'array',
            'error.name' => 'array',
            'error.name.0' => 'string',
        ])
        ->where('error.name.0', ProductNameMessage::PRODUCT_NAME_MUST_BE_A_STRING)
    )
);

it('should return product price must be a number message when product price field is not a number', fn (): TestResponse => $this
    ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, ['price' => 'abc'])
    ->assertBadRequest()
    ->assertJson(fn (AssertableJson $json): AssertableJson => $json
        ->hasAll([
            'error',
            'error.price',
            'error.price.0',
        ])
        ->whereAllType([
            'error' => 'array',
            'error.price' => 'array',
            'error.price.0' => 'string',
        ])
        ->where('error.price.0', ProductPriceMessage::PRODUCT_PRICE_MUST_BE_A_NUMBER)
    )
);

it('should return product price must be greater than zero message when product price field is less than zero', fn (): TestResponse => $this
    ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, ['price' => -1])
    ->assertBadRequest()
    ->assertJson(fn (AssertableJson $json): AssertableJson => $json
        ->hasAll([
            'error',
            'error.price',
            'error.price.0',
        ])
        ->whereAllType([
            'error' => 'array',
            'error.price' => 'array',
            'error.price.0' => 'string',
        ])
        ->where('error.price.0', ProductPriceMessage::PRODUCT_PRICE_MUST_BE_GREATER_THAN_ZERO)
    )
);

it('should update only product category and return updated product data', function (): void {

    $category = Category::factory()->create();

    $this
        ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, ['category_id' => $category->id])
        ->assertOk()
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json
            ->hasAll([
                'data',
                'data.id',
                'data.category_id',
                'data.name',
                'data.price',
                'data.created_at',
                'data.updated_at',
            ])
            ->whereAllType([
                'data' => 'array',
                'data.id' => 'string',
                'data.category_id' => 'string',
                'data.name' => 'string',
                'data.price' => 'double',
                'data.created_at' => 'string',
                'data.updated_at' => 'string',
            ])
            ->whereAll([
                'data.category_id' => $category->id,
                'data.name' => $this->product->name,
                'data.price' => $this->product->price,
            ])
        );
});

it('should update only product name and return updated product data', fn (): TestResponse => $this
    ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, [
        'category_id' => $this->product->category->id,
        'name' => 'Product 2',
    ])
    ->assertOk()
    ->assertJson(fn (AssertableJson $json): AssertableJson => $json
        ->hasAll([
            'data',
            'data.id',
            'data.category_id',
            'data.name',
            'data.price',
            'data.created_at',
            'data.updated_at',
        ])
        ->whereAllType([
            'data' => 'array',
            'data.id' => 'string',
            'data.category_id' => 'string',
            'data.name' => 'string',
            'data.price' => 'double|integer',
            'data.created_at' => 'string',
            'data.updated_at' => 'string',
        ])
        ->whereAll([
            'data.id' => $this->product->id,
            'data.category_id' => $this->product->category->id,
            'data.name' => 'Product 2',
            'data.price' => $this->product->price,
        ])
    ));

it('should update only product price and return updated product data', fn (): TestResponse => $this
    ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, [
        'category_id' => $this->product->category->id,
        'price' => 4.5,
    ])
    ->assertOk()
    ->assertJson(fn (AssertableJson $json): AssertableJson => $json
        ->hasAll([
            'data',
            'data.id',
            'data.category_id',
            'data.name',
            'data.price',
            'data.created_at',
            'data.updated_at',
        ])
        ->whereAllType([
            'data' => 'array',
            'data.id' => 'string',
            'data.category_id' => 'string',
            'data.name' => 'string',
            'data.price' => 'double',
            'data.created_at' => 'string',
            'data.updated_at' => 'string',
        ])
        ->whereAll([
            'data.id' => $this->product->id,
            'data.category_id' => $this->product->category->id,
            'data.name' => $this->product->name,
            'data.price' => 4.5,
        ])
    ));

it('should update entire product and return updated product data', function (): void {

    $category = Category::factory()->create();

    $this
        ->patchJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$this->product->id, [
            'category_id' => $category->id,
            'name' => 'Product 2',
            'price' => 4.5,
        ])
        ->assertOk()
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json
            ->hasAll([
                'data',
                'data.id',
                'data.category_id',
                'data.name',
                'data.price',
                'data.created_at',
                'data.updated_at',
            ])
            ->whereAllType([
                'data' => 'array',
                'data.id' => 'string',
                'data.category_id' => 'string',
                'data.name' => 'string',
                'data.price' => 'double',
                'data.created_at' => 'string',
                'data.updated_at' => 'string',
            ])
            ->whereAll([
                'data.id' => $this->product->id,
                'data.category_id' => $category->id,
                'data.name' => 'Product 2',
                'data.price' => 4.5,
            ])
        );
});
