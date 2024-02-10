<?php

namespace Parables\Utils;

it('can ...', function ($input, $output) {
    expect(normalizeWhitespace(string: $input))->toBe($output);
})->with([
    ['', ''],
])->todo();
