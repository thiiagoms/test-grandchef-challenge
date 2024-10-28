<?php

use App\Models\Product;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

it('should return products paginated results with 10 itens per page when products exists in database', function (): void {

    Product::factory(20)->create();

    $this
        ->getJson(PRODUCT_ENDPOINT)
        ->assertOk()
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json
            ->hasAll([
                'data',
                'links',
                'meta',
            ])
            ->whereAllType([
                'data' => 'array',
                'links' => 'array',
                'links.first' => 'string',
                'links.last' => 'string',
                'links.prev' => 'string|null',
                'links.next' => 'string|null',
                'meta' => 'array',
                'meta.current_page' => 'integer',
                'meta.from' => 'integer',
                'meta.last_page' => 'integer',
                'meta.links' => 'array',
            ])
            ->count('data', 10)
        );
});

it('should return empty data when no products exists in database', fn (): TestResponse => $this
    ->getJson(PRODUCT_ENDPOINT)
    ->assertOk()
    ->assertJson(fn (AssertableJson $json): AssertableJson => $json
        ->hasAll([
            'data',
            'links',
            'meta',
        ])
        ->whereAllType([
            'data' => 'array',
            'links' => 'array',
            'links.first' => 'string',
            'links.last' => 'string',
            'links.prev' => 'null',
            'links.next' => 'null',
            'meta' => 'array',
            'meta.current_page' => 'integer',
            'meta.from' => 'null',
            'meta.last_page' => 'integer',
            'meta.links' => 'array',
        ])
        ->count('data', 0)
    )
);
