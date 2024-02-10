<?php

namespace Parables\Utils;

it('can transform the keys in an array', function (
  array $input,
  array $output,
  string $callback = 'camel_case',
  array $preserveKeys = ['$id', 'data.$href', 'data.root_div.1'],
) {
  expect(array_keys_transform(payload: $input, callback: $callback, preserveKeys: $preserveKeys))->toBe($output);
})->with([
  [
    [
      '$id' => '123',
      'MESSAGE' => 'success',
      'data' => [
        'name' => 'John',
        'age' => 12,
        '$href' => 'http://example.com',
        'root_div' => [['index'], 'WoRlD'],
      ],
    ],

    [
      '$id' => '123',
      'message' => 'success',
      'data' => [
        'name' => 'John',
        'age' => 12,
        '$href' => 'http://example.com',
        'rootDiv' => [['index'],  'WoRlD'],
      ],
    ],
  ],
]);
