<?php

declare(strict_types=1);

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

it('should delete product when product id is valid uuid and exists in database', function (): void {

    $product = Product::factory()->createOne();

    $this
        ->deleteJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$product->id)
        ->assertNoContent();

    $this
        ->getJson(PRODUCT_ENDPOINT.DIRECTORY_SEPARATOR.$product->id)
        ->assertNotFound()
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json
            ->has('message')
            ->whereType('message', 'string')
            ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        );
});
