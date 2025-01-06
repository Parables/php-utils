<?php

// NOTE: This file safely exposes all the helper functions
// as global functions
//
// TODO: register any new functions added to the Utils class and traits here

use Parables\Utils\Utils;

if (!function_exists('instance_or_default')) {
  function instance_or_default(
    mixed $instance,
    mixed $value,
    mixed $defaultValue = null
  ): mixed {
    return Utils::instanceOrDefault(...func_get_args());
  }
}

if (!function_exists('array_flatten')) {
  function array_flatten(array $array)
  {
    return Utils::arrayFlatten(...func_get_args());
  }
}

if (!function_exists('array_keys_transform')) {
  function array_keys_transform(
    array $payload,
    \Closure|string $callback,
    array $preserveKeys = [],
    string $prefix = '',
  ): array {
    return Utils::arrayKeysTransform(...func_get_args());
  }
}

if (!function_exists('array_unique_values')) {
  function array_unique_values(array $array)
  {
    return Utils::arrayUniqueValues(...func_get_args());
  }
}

if (!function_exists('array_wrap')) {
  function array_wrap(mixed $value): array
  {
    return Utils::arrayWrap(...func_get_args());
  }
}

if (!function_exists('array_to_string')) {
  function array_to_string(array $value): string
  {
    return Utils::arrayToString(...func_get_args());
  }
}

if (!function_exists('array_delta')) {
  function array_delta(
    array $array1,
    array $array2,
    array $ignoreKeys = [],
    callable $compare = null,
  ): array {
    return Utils::arrayDelta(...func_get_args());
  }
}

if (!function_exists('excel_date_to_php_date')) {
  function excel_date_to_php_date(?int $excelDate = null): ?string
  {
    return Utils::excelDateToPhpDate(...func_get_args());
  }
}

if (!function_exists('normalize_whitespace')) {
  function normalize_whitespace(string $string = ''): string
  {
    return Utils::normalizeWhitespace(...func_get_args());
  }
}

if (!function_exists('capitalize')) {
  function capitalize(string $string = ''): string
  {
    return Utils::capitalize(...func_get_args());
  }
}

if (!function_exists('slugify')) {
  function slugify(string $string = '', bool $toLowerCase = true): string
  {
    return Utils::slugify(...func_get_args());
  }
}

if (!function_exists('words')) {
  function words(string $string = ''): array
  {
    return Utils::words(...func_get_args());
  }
}

if (!function_exists('is_all_upper_case')) {
  function is_all_upper_case(string $string): bool
  {
    return Utils::isAllUpperCase(...func_get_args());
  }
}

if (!function_exists('pascal_case')) {
  function pascal_case(string $string = ''): string
  {
    return Utils::pascalCase(...func_get_args());
  }
}

if (!function_exists('camel_case')) {
  function camel_case(string $string = ''): string
  {
    return Utils::camelCase(...func_get_args());
  }
}

if (!function_exists('snake_case')) {
  function snake_case(string $string = ''): string
  {
    return Utils::snakeCase(...func_get_args());
  }
}

if (!function_exists('kebab_case')) {
  function kebab_case(string $string): string
  {
    return Utils::kebabCase(...func_get_args());
  }
}

if (!function_exists('is_url')) {
  function is_url(string $url = ''): bool
  {
    return Utils::isUrl(...func_get_args());
  }
}

if (!function_exists('is_valid_url')) {
  function is_valid_url(string $url): bool
  {
    return Utils::isValidUrl(...func_get_args());
  }
}

if (!function_exists('config_or_env')) {
  function config_or_env(
    string $configKey,
    string $envKey,
    mixed $defaultValue = null,
  ) {
    return Utils::configOrEnv(...func_get_args());
  }
}
