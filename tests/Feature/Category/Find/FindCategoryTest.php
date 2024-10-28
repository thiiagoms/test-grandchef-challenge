<?php

use App\Messages\System\SystemMessage;
use App\Models\Category;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

it('should return resource not found message when category id is not a valid uuid',
    fn (): TestResponse => $this
        ->getJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.'invalid-uuid')
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        )
);

it('should return resource not found when category id is valid uuid but does not exists in database',
    fn (): TestResponse => $this
        ->getJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.fake()->uuid())
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        )
);

it('should return category data when category id is valid uuid and exists in database', function (): void {

    $category = Category::factory()->create();

    $this
        ->getJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$category->id)
        ->assertOk()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->hasAll([
                    'data',
                    'data.id',
                    'data.name',
                    'data.description',
                    'data.created_at',
                    'data.updated_at',
                ])
                ->whereAllType([
                    'data' => 'array',
                    'data.id' => 'string',
                    'data.name' => 'string',
                    'data.description' => 'string',
                    'data.created_at' => 'string',
                    'data.updated_at' => 'string',
                ])
                ->whereAll([
                    'data.id' => $category->id,
                    'data.name' => $category->name,
                    'data.description' => $category->description,
                ])
        );
});
