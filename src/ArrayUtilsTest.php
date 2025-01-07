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

  // TODO: add more test cases


  // Test 12: Multiple types of changes simultaneously
  [
    ['a' => 1, 'b' => 2, 'c' => 3, 'nested' => ['x' => 10]],
    ['a' => 1, 'b' => 20, 'd' => 4, 'nested' => ['x' => 10, 'y' => 20]],
    [
      'modified' => ['b' => ['before' => 2, 'after' => 20]],
      'removed' => ['c' => 3],
      'added' => ['nested.y' => 20, 'd' => 4],
    ],
  ],

  // Test 13: Deep nested structure changes
  [
    ['level1' => ['level2' => ['level3' => ['value' => 'old']]]],
    ['level1' => ['level2' => ['level3' => ['value' => 'new']]]],
    ['modified' => ['level1.level2.level3.value' => ['before' => 'old', 'after' => 'new']]],
  ],

  // Test 14: Array to non-array type change
  [
    ['key' => ['nested' => 'value']],
    ['key' => 'string'],
    ['modified' => ['key' => ['before' => ['nested' => 'value'], 'after' => 'string']]],
  ],

  // Test 15: Non-array to array type change
  [
    ['key' => 'string'],
    ['key' => ['nested' => 'value']],
    ['modified' => ['key' => ['before' => 'string', 'after' => ['nested' => 'value']]]],
  ],

  // Test 16: Mixed numeric and string keys
  [
    [0 => 'zero', 'one' => 1, 2 => 'two'],
    [0 => 'zero_new', 'one' => 1, 2 => 'two'],
    ['modified' => ['0' => ['before' => 'zero', 'after' => 'zero_new']]],
  ],

  // Test 17: Special characters in keys
  [
    ['key.with.dots' => 'old', 'key with spaces' => 'old'],
    ['key.with.dots' => 'new', 'key with spaces' => 'new'],
    [
      'modified' => [
        'key.with.dots' => ['before' => 'old', 'after' => 'new'],
        'key with spaces' => ['before' => 'old', 'after' => 'new'],
      ],
    ],
  ],

  // Test 18: Multiple ignore keys at different levels
  [
    ['a' => ['x' => 1, 'y' => 2], 'b' => ['m' => 3, 'n' => 4]],
    ['a' => ['x' => 10, 'y' => 20], 'b' => ['m' => 30, 'n' => 40]],
    [
      'modified' => [
        'a.x' => ['before' => 1, 'after' => 10],
        'b.n' => ['before' => 4, 'after' => 40],
      ],
    ],
    ['a.y', 'b.m'],
  ],

  // Test 19: Custom compare function with objects
  [
    ['obj' => new \DateTime('2023-01-01')],
    ['obj' => new \DateTime('2023-01-01 00:00:00')],
    [],
    [],
    fn($v1, $v2) => $v1->getTimestamp() !== $v2->getTimestamp(),
  ],

  // Test 20: Empty strings and null values
  [
    ['empty1' => '', 'null1' => null, 'zero' => 0],
    ['empty2' => '', 'null2' => null, 'zero' => '0'],
    [
      'removed' => ['empty1' => '', 'null1' => null],
      'modified' => ['zero' => ['before' => 0, 'after' => '0']],
      'added' => ['empty2' => '', 'null2' => null],
    ],
  ],

  // Test 21: Nested arrays with multiple ignore patterns
  [
    [
      'config' => [
        'debug' => true,
        'temp' => ['path' => '/tmp'],
        'cache' => ['enabled' => true],
      ],
    ],
    [
      'config' => [
        'debug' => false,
        'temp' => ['path' => '/var/tmp'],
        'cache' => ['enabled' => false],
      ],
    ],
    [
      'modified' => [
        'config.debug' => ['before' => true, 'after' => false],
        'config.cache.enabled' => ['before' => true, 'after' => false],
      ],
    ],
    ['config.temp.path'],
  ],

  // Test 22: Large nested structure performance test
  [
    array_merge(
      ['stable' => array_fill(0, 100, 'unchanged')],
      ['changing' => array_fill(0, 5, 'old')],
    ),
    array_merge(
      ['stable' => array_fill(0, 100, 'unchanged')],
      ['changing' => array_fill(0, 5, 'new')],
    ),
    [
      'modified' => array_combine(
        array_map(fn($i) => "changing.$i", range(0, 4)),
        array_fill(0, 5, ['before' => 'old', 'after' => 'new'])
      ),
    ],
  ],

  // Test 23: Edge case with boolean values
  [
    ['flag1' => true, 'flag2' => false],
    ['flag1' => 1, 'flag2' => 0],
    [
      'modified' => [
        'flag1' => ['before' => true, 'after' => 1],
        'flag2' => ['before' => false, 'after' => 0],
      ],
    ],
  ],
]);
