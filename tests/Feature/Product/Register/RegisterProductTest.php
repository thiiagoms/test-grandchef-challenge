<?php

use App\Messages\Product\ProductCategoryMessage;
use App\Messages\Product\ProductNameMessage;
use App\Messages\Product\ProductPriceMessage;
use App\Models\Category;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

beforeEach(fn (): Category => $this->category = Category::factory()->createOne());

it('should return category id field is required message when category name field is empty', fn (): TestResponse => $this
    ->postJson(PRODUCT_ENDPOINT, ['category_id' => ''])
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
        ->postJson(PRODUCT_ENDPOINT, ['category_id' => 'invalid-ID'])
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
        ->postJson(PRODUCT_ENDPOINT, ['category_id' => fake()->uuid()])
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

it('should return product name field is required message when product name field is empty', fn (): TestResponse => $this
    ->postJson(PRODUCT_ENDPOINT, ['name' => ''])
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
        ->where('error.name.0', ProductNameMessage::PRODUCT_NAME_IS_REQUIRED)
    )
);

it('should return product name must be a string message when product name field is not a string', fn (): TestResponse => $this
    ->postJson(PRODUCT_ENDPOINT, ['name' => 123])
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

it('should return product price field is required message when product price field is empty', fn (): TestResponse => $this
    ->postJson(PRODUCT_ENDPOINT, ['price' => ''])
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
        ->where('error.price.0', ProductPriceMessage::PRODUCT_PRICE_IS_REQUIRED)
    )
);

it('should return product price must be a number message when product price field is not a number', fn (): TestResponse => $this
    ->postJson(PRODUCT_ENDPOINT, ['price' => 'abc'])
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
    ->postJson(PRODUCT_ENDPOINT, ['price' => -1])
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

it('should created product data when all provided data is valid and product is created', fn (): TestResponse => $this
    ->postJson(PRODUCT_ENDPOINT, [
        'category_id' => $this->category->id,
        'name' => 'Product 1 name',
        'price' => 3.50,
    ])
    ->assertCreated()
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
            'data.category_id' => $this->category->id,
            'data.name' => 'Product 1 name',
            'data.price' => 3.50,
        ])
    )
);
