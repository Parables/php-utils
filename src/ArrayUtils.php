<?php

namespace Parables\Utils;

trait ArrayUtils
{
  /**
   * @param  array<int,mixed>  $array
   */
  public static function arrayFlatten(array $array): array
  {
    $result = [];
    array_walk_recursive($array, function ($a) use (&$result) {
      $result[] = $a;
    });

    return $result;
  }

  /**
   * @param  array<int,mixed>  $payload
   * @param  array<int,mixed>  $preserveKeys
   */
  public static function arrayKeysTransform(
    array $payload,
    \Closure|string $callback,
    array $preserveKeys = [],
    string $prefix = '',
  ): array {
    $result = [];

    foreach ($payload as $key => $value) {

      $_key = $key;
      $needle = empty($prefix) ? $key : $prefix . '.' . $key;

      if (!in_array(needle: $needle, haystack: $preserveKeys)) {
        $_key = $callback($key);
      }

      if (is_array($value)) {
        $result[$_key] = self::arrayKeysTransform(
          payload: $value,
          callback: $callback,
          preserveKeys: $preserveKeys,
          prefix: empty($prefix) ? $key : $prefix . '.' . $key,
        );
      } else {
        $result[$_key] = $value;
      }
    }

    return $result;
  }

  /**
   * @param  array<int,mixed>  $array
   * @return mixed[]
   */
  public static function arrayUniqueValues(array $array): array
  {
    $unique = [];
    $uniqueStr = [];
    foreach ($array as $item) {
      $_item = json_encode($item);
      if (!in_array(needle: $_item, haystack: $uniqueStr)) {
        $uniqueStr[] = $_item;
        $unique[] = $item;
      }
    }

    return $unique;
  }


  public static function arrayWrap(mixed $value): array
  {
    return match (true) {
      is_null($value) => [],
      is_array($value) => $value,
      default => [$value],
    };
  }

  public static function arrayToString(array $value): string
  {
    $output = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    $output = str_replace(search: '{', replace: '[', subject: $output);
    $output = str_replace(search: '}', replace: ']', subject: $output);
    $output = str_replace(search: ':', replace: '=>', subject: $output);
    $output = str_replace(search: '"', replace: "'", subject: $output);

    return $output;
  }

  /**
   * Calculates the delta(changes) between two arrays.
   *
   * @param array $array1 The first array.
   * @param array $array2 The second array.
   * @param array $ignoreKeys An array of keys to ignore when comparing.
   * @param callable|null $compare A callable function used to compare values.
   *
   * @return array An associative array of 'added', 'removed', and 'modified' changes.
   */
  public static function arrayDelta(
    array $array1,
    array $array2,
    array $ignoreKeys = [],
    callable $compare = null,
    array $path = [],
  ): array {
    $compare ??= fn($v1, $v2) => $v1 !== $v2;
    $changes = [];

    // Early exit if both arrays are empty
    if (empty($array1) && empty($array2)) {
      return $changes;
    }

    // Process all keys from both arrays
    foreach (array_unique([...array_keys($array1), ...array_keys($array2)]) as $key) {
      $currentPath = [...$path, $key];
      $currentPathStr = implode('.', $currentPath);

      if (in_array($currentPathStr, $ignoreKeys)) {
        continue;
      }

      if (!array_key_exists($key, $array1)) {
        $changes['added'][$currentPathStr] = $array2[$key];
      } elseif (!array_key_exists($key, $array2)) {
        $changes['removed'][$currentPathStr] = $array1[$key];
      } elseif (is_array($array1[$key]) && is_array($array2[$key])) {
        $result = self::arrayDelta(
          $array1[$key],
          $array2[$key],
          $ignoreKeys,
          $compare,
          $currentPath
        );
        foreach (['added', 'modified', 'removed'] as $type) {
          if (!empty($result[$type])) {
            $changes[$type] = [...$changes[$type] ?? [], ...$result[$type]];
          }
        }
      } elseif ($compare($array1[$key], $array2[$key])) {
        $changes['modified'][$currentPathStr] = [
          'before' => $array1[$key],
          'after' => $array2[$key]
        ];
      }
    }

    return array_filter($changes);
  }
}
