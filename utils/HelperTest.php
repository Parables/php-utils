<?php

it('removes extra whitespace and trims the string', function ($input, $output) {
    expect(normalize_whitespace(string: $input))->toBe($output);
})->with([
    [
        "  This string \n has \t extra  \v   spaces .   ",
        'This string has extra spaces .',
    ],
]);

it('capitalizes first letter of each word, lowercase rest.', function ($input, $output) {
    expect(capitalize(string: $input))->toBe($output);
})->with([
    ['this SENTENCE needs CAPITALIZATION!', 'This Sentence Needs Capitalization'],
]);

it('converts to URL-friendly format with dashes', function ($input, $output) {
    expect(slugify(string: $input))->toBe($output);
})->with([
    ['My Awesome Product Name!', 'my-awesome-product-name'],
]);

it('splits a string into an array of words, preserving capitalization for single words', function ($input, $output) {
    expect(words(string: $input))->toBe($output);
})->with([
    [
        'This is a sentence with multiple words.',
        ['This', 'Is', 'A', 'Sentence', 'With', 'Multiple', 'Words'],
    ],
]);

it('checks if all characters are uppercase', function ($input, $output) {
    expect(is_all_upper_case(string: $input))->toBe($output);
})->with([
    ['ALL UPPERCASE', true],
    ['Not All Uppercase', false],
]);

it('converts to PascalCase', function ($input, $output) {
    expect(pascal_case(string: $input))->toBe($output);
})->with([
    ['this is a string"', 'ThisIsAString'],
]);

it('converts to camelCase', function ($input, $output) {
    expect(camel_case(string: $input))->toBe($output);
})->with([
    ['This is a string', 'thisIsAString'],
]);

it('converts to snake_case', function ($input, $output) {
    expect(snake_case(string: $input))->toBe($output);
})->with([
    ['This is a string', 'this_is_a_string'],
]);

it('converts to kebab-case ', function ($input, $output) {
    expect(kebab_case(string: $input))->toBe($output);
})->with([
    ['This is a string', 'this-is-a-string'],
]);

it('checks if a string is a valid url', function ($input, $output) {
    expect(is_url(url: $input))->toBe($output);
})->with([
    ['https://www.example.com', true],
    ['/example.com', false],
]);

it('checks if a string is a valid url with a scheme and host', function ($input, $output) {
    expect(is_valid_url(url: $input))->toBe($output);
})->with([
    ['https://www.example.com', true],
    ['/example.com', false],
]);
