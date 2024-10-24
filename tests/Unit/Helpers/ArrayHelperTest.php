<?php

use Pest\Expectation;

dataset('removeEmpty helper provider', fn (): array => [
    'should remove empty values from array and return new array without empty values' => [
        'payload' => [
            'foo' => 'foo',
            'bar' => 'bar',
            'qux' => '',
        ],
        'result' => [
            'foo' => 'foo',
            'bar' => 'bar',
        ],
    ],
    'should return entire array if payload array is not empty' => [
        'payload' => [
            'foo' => 'foo',
            'bar' => 'bar',
            'qux' => 'qux',
        ],
        'result' => [
            'foo' => 'foo',
            'bar' => 'bar',
            'qux' => 'qux',
        ],
    ],
    'should return empty array if payload array is empty' => [
        'payload' => [],
        'result' => [],
    ],
]);

test('removeEmpty helper', fn (array $payload, array $result): Expectation => expect(removeEmpty($payload))->toBe($result)
)->with('removeEmpty helper provider');
