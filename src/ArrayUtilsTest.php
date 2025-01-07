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

it(
  'computes the delta(changes) in $array1 by $array2',
  function ($array1 = [], $array2 = [], $expected = [], $ignoreKeys = [], $compare = null) {
    expect(array_delta(
      array1: $array1,
      array2: $array2,
      ignoreKeys: $ignoreKeys,
      compare: $compare,
    ))->toBe($expected);
  }
)->with([

  // Test 0: Empty Arrays
  [],

  // Test 1: No Changes
  [
    ['foo' => 'bar', 'baz' => 123],
    ['foo' => 'bar', 'baz' => 123],
  ],

  // Test 2: No Changes even with nested arrays
  [
    ['foo' => 'bar', 'baz' => 123, 'nested' => ['a' => 1, 'b' => 2]],
    ['foo' => 'bar', 'baz' => 123, 'nested' => ['a' => 1, 'b' => 2]],
  ],

  // Test 3: Simple Addition
  [
    ['foo' => 'bar'],
    ['foo' => 'bar', 'new' => 'value'],
    ['added' => ['new' => 'value']],
  ],

  // Test 4: Simple Removal
  [
    ['foo' => 'bar', 'bar' => 'baz'],
    ['foo' => 'bar'],
    ['removed' => ['bar' => 'baz']],
  ],

  // Test 5: Simple Modification
  [
    ['foo' => 'bar',],
    ['foo' => 'baz',],
    ['modified' => ['foo' => ['before' => 'bar', 'after' => 'baz']]],
  ],

  // Test 6: Nested Addition
  [
    ['foo' => ['bar' => 'baz',],],
    ['foo' => ['bar' => 'baz', 'new' => 'value',],],
    ['added' => ['foo.new' => 'value']],
  ],

  // Test 7: Nested Removal
  [
    ['foo' => ['bar' => 'baz', 'old' => 'value']],
    ['foo' => ['bar' => 'baz']],
    ['removed' => ['foo.old' => 'value']],
  ],

  // Test 8: Nested Modification
  [
    ['foo' => ['bar' => 'baz',],],
    ['foo' => ['bar' => 'qux',],],
    ['modified' => ['foo.bar' => ['before' => 'baz', 'after' => 'qux']]],
  ],

  // Test 9: Ignore Keys
  [
    ['foo' => 'bar', 'bar' => 'baz'],
    ['foo' => 'bar', 'bar' => 'qux'],
    [],
    ['bar'],
  ],

  // Test 10: Ignore Nested Keys
  [
    ['foo' => ['bar' => 'baz']],
    ['foo' => ['bar' => 'qux']],
    [],
    ['foo.bar'],
  ],

  // Test 11: Custom Compare Function (Case-Insensitive)
  [
    ['foo' => 'Bar'],
    ['foo' => 'bar'],
    [],
    [],
    function ($value1, $value2) {
      return strtolower($value1) !== strtolower($value2);
    },
  ],

]);
