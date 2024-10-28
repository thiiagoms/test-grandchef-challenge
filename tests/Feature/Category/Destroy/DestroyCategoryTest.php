<?php

use App\Messages\System\SystemMessage;
use App\Models\Category;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

it('should return resource not found when category id is not a valid uuid',
    fn (): TestResponse => $this
        ->deleteJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.'invalid-uuid')
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
        ->deleteJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.fake()->uuid())
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        )
);

it('should delete category when category id is valid uuid and exists in database', function (): void {

    $category = Category::factory()->create();

    $this
        ->deleteJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$category->id)
        ->assertNoContent();

    $this
        ->getJson(CATEGORY_ENDPOINT.DIRECTORY_SEPARATOR.$category->id)
        ->assertNotFound()
        ->assertJson(
            fn (AssertableJson $json): AssertableJson => $json
                ->has('message')
                ->whereType('message', 'string')
                ->where('message', SystemMessage::RESOURCE_NOT_FOUND),
        );
});
