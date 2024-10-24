<?php

if (! function_exists('clean')) {

    function clean(string|array $payload): array|string
    {
        return gettype($payload) === 'array'
            ? array_map(fn (mixed $field): string => trim(strip_tags($field)), $payload)
            : trim(strip_tags($payload));
    }
}
