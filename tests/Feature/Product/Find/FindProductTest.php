<?php

use App\Messages\System\SystemMessage;
use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

it('should return resource not found message when product id is not a valid uuid', fn (): TestResponse => $this
    ->getJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.'invalid-uuid')
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
        ->getJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.fake()->uuid())
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        )
);

it('should return product data when product id is valid uuid and exists in database', function (): void {

    $product = Product::factory()->createOne();

    $this
        ->getJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$product->id)
        ->assertOk()
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json
            ->hasAll([
                'data',
                'data.id',
                'data.name',
                'data.price',
                'data.category.id',
                'data.category.name',
                'data.category.description',
                'data.category.created_at',
                'data.category.updated_at',
                'data.created_at',
                'data.updated_at',
            ])
            ->whereAllType([
                'data' => 'array',
                'data.id' => 'string',
                'data.name' => 'string',
                'data.price' => 'double',
                'data.category.id' => 'string',
                'data.category.name' => 'string',
                'data.category.description' => 'string',
                'data.category.created_at' => 'string',
                'data.category.updated_at' => 'string',
                'data.created_at' => 'string',
                'data.updated_at' => 'string',
            ])
            ->whereAll([
                'data.id' => $product->id,
                'data.name' => $product->name,
                'data.price' => $product->price,
                'data.category.id' => $product->category->id,
                'data.category.name' => $product->category->name,
                'data.category.description' => $product->category->description,
            ])
        );
});
