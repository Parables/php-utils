<?php

namespace Parables\Utils;

it('can normalize the whitespace in a string', function ($input, $output) {
  expect(Utils::normalizeWhitespace(string: $input))->toBe($output);
})->with([
  ['', ''],
  ['hello ', 'hello'],
  [' hello    world', 'hello world'],
  ["\v this \t string \n", 'this string'],
]);

it(
  'can convert to PascalCase',
  function ($input, $output) {
    expect(Utils::pascalCase(string: $input))->toBe($output);
  }
)->with(
  [

    ['hello world', 'HelloWorld'],
    ['HELLO WORLD', 'HelloWorld'],
    ['Hello World', 'HelloWorld'],
    ['helloWorld', 'HelloWorld'],
    ['hello_world', 'HelloWorld'],
    ['hello-world', 'HelloWorld'],
    ['HelloWorld', 'HelloWorld'],
    ['Hello_World', 'HelloWorld'],
    ['Hello-World', 'HelloWorld'],
    ['HELLO_WORLD', 'HelloWorld'],
    ['HELLO-WORLD', 'HelloWorld'],
    ['hello_world_123', 'HelloWorld123'],
    ['hello_World_123', 'HelloWorld123'],
    ['Hello_World_123', 'HelloWorld123'],
    ['helloWorld123', 'HelloWorld123'],
    ['HelloWorld123', 'HelloWorld123'],
    ['', ''],
    ['hElLo Wor&ld', 'HelloWorld'],
    ['hElLo% @World&123', 'HelloWorld123'],
    ['hElLo_ - _ Wor^&ld', 'HelloWorld'],
    /*
        */
  ]
);

it(
  'can convert to camelCase',
  function ($input, $output) {
    expect(Utils::camelCase(string: $input))->toBe($output);
  }
)->with(
  [
    ['hello world', 'helloWorld'],
    ['HELLO WORLD', 'helloWorld'],
    ['Hello World', 'helloWorld'],
    ['helloWorld', 'helloWorld'],
    ['hello_world', 'helloWorld'],
    ['hello-world', 'helloWorld'],
    ['HelloWorld', 'helloWorld'],
    ['Hello_World', 'helloWorld'],
    ['Hello-World', 'helloWorld'],
    ['HELLO_WORLD', 'helloWorld'],
    ['HELLO-WORLD', 'helloWorld'],
    ['hello_world_123', 'helloWorld123'],
    ['hello_World_123', 'helloWorld123'],
    ['Hello_World_123', 'helloWorld123'],
    ['helloWorld123', 'helloWorld123'],
    ['HelloWorld123', 'helloWorld123'],
    ['', ''],
    ['hElLo Wor$ld', 'helloWorld'],
    ['hElLo% @World&123', 'helloWorld123'],
    ['hElLo_ - _ Wor$ld', 'helloWorld'],
  ]
);

it(
  'can convert to snake_case',
  function ($input, $output) {
    expect(Utils::snakeCase(string: $input))->toBe($output);
  }
)->with(
  [
    ['basic-6', 'basic_6'],
    ['basic 6', 'basic_6'],
    ['hello world', 'hello_world'],
    ['HELLO WORLD', 'h_e_l_l_o_w_o_r_l_d'],
    [strtolower('HELLO WORLD'), 'hello_world'],
    ['Hello World', 'hello_world'],
    ['helloWorld', 'hello_world'],
    ['hello_world', 'hello_world'],
    ['hello-world', 'hello_world'],
    ['HelloWorld', 'hello_world'],
    ['Hello_World', 'hello_world'],
    ['Hello-World', 'hello_world'],
    ['HELLO_WORLD', 'h_e_l_l_o_w_o_r_l_d'],
    ['HELLO-WORLD', 'h_e_l_l_o_w_o_r_l_d'],
    ['hello_world_123', 'hello_world_123'],
    ['hello_World_123', 'hello_world_123'],
    ['hello_World-123', 'hello_world_123'],
    ['Hello_World_123', 'hello_world_123'],
    ['helloWorld123', 'hello_world123'],
    ['HelloWorld123', 'hello_world123'],
    ['HelloWorld-123', 'hello_world_123'],
    ['HelloWorld_123', 'hello_world_123'],
    ['', ''],
    ['hElLo Wor$ld', 'h_el_lo_world'],
    ['hElLo% @World&123', 'h_el_lo_world123'],
    ['hElLo_ - _ Wor$ld', 'h_el_lo_world'],
  ]
);

it(
  'can convert to kebab-case',
  function ($input, $output) {
    expect(Utils::kebabCase(string: $input))->toBe($output);
  }
)->with(
  [

    ['hello world', 'hello-world'],
    ['HELLO WORLD', 'h-e-l-l-o-w-o-r-l-d'],
    [strtolower('HELLO WORLD'), 'hello-world'],
    ['Hello World', 'hello-world'],
    ['helloWorld', 'hello-world'],
    ['hello_world', 'hello-world'],
    ['hello-world', 'hello-world'],
    ['HelloWorld', 'hello-world'],
    ['Hello_World', 'hello-world'],
    ['Hello-World', 'hello-world'],
    ['HELLO_WORLD', 'h-e-l-l-o-w-o-r-l-d'],
    ['HELLO-WORLD', 'h-e-l-l-o-w-o-r-l-d'],
    ['hello_world_123', 'hello-world-123'],
    ['hello_World_123', 'hello-world-123'],
    ['hello_World-123', 'hello-world-123'],
    ['Hello_World_123', 'hello-world-123'],
    ['helloWorld123', 'hello-world123'],
    ['HelloWorld123', 'hello-world123'],
    ['HelloWorld-123', 'hello-world-123'],
    ['HelloWorld_123', 'hello-world-123'],
    ['', ''],
    ['hElLo Wor$ld', 'h-el-lo-world'],
    ['hElLo% @World&123', 'h-el-lo-world123'],
    ['hElLo_ - _ Wor$ld', 'h-el-lo-world'],
  ]
);
