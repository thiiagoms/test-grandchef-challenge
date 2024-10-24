<?php

use Pest\Expectation;

dataset('clean helper provider', fn (): array => [
    'should remove spaces and html tags from string' => [
        'payload' => ' <h1>Hello World</h1> ',
        'result' => 'Hello World',
    ],
    'should remove spaces and html tags from each element of array' => [
        'payload' => [
            ' Hello World ',
            ' <script>console.log("Hello World")</script> ',
        ],
        'result' => [
            'Hello World',
            'console.log("Hello World")',
        ],
    ],
    'should return empty array if payload is empty' => [
        'payload' => [],
        'result' => [],
    ],
]);

test('clean helper', fn (string|array $payload, string|array $result): Expectation => expect(clean($payload))->toBe($result)
)->with('clean helper provider');
