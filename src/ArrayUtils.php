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
   *                                      Defaults to strict inequality (`!==`).
   *
   * @return array An associative array containing the following keys:
   *     - 'added': An array of keys and their values added in $array2.
   *     - 'removed': An array of keys and their values removed from $array1.
   *     - 'modified': An array of keys and their before/after values.
   */
  public static function arrayDelta(
    array $array1,
    array $array2,
    array $ignoreKeys = [],
    callable $compare = null,
    array $path = [],
  ): array {
    $changes = [];

    $compare ??= function ($value1, $value2) {
      return $value1 !== $value2;
    };

    // Early exit: If both arrays are empty, no changes exist
    if (empty($array1) && empty($array2)) {
      return $changes;
    }

    foreach ($array1 as $key => $value) {
      $currentPath = array_merge($path, [$key]);
      $currentPathStr = implode('.', $currentPath);

      if (in_array($currentPathStr, $ignoreKeys)) {
        continue; // Skip keys that should be ignored
      }

      if (!array_key_exists($key, $array2)) {
        $changes['removed'][$currentPathStr] = $value;
      } elseif (is_array($value) && is_array($array2[$key])) {
        $result =
          self::arrayDelta(
            array1: $array1[$key],
            array2: $array2[$key],
            ignoreKeys: $ignoreKeys,
            compare: $compare,
            path: $currentPath,
          );

        $changes = [
          'added' => array_merge($changes['added'] ?? [], $result['added'] ?? []),
          'modified' => array_merge($changes['modified'] ?? [], $result['modified'] ?? []),
          'removed' => array_merge($changes['removed'] ?? [], $result['removed'] ?? []),
        ];
      } elseif ($compare($value, $array2[$key])) {
        $changes['modified'][$currentPathStr] = [
          'before' => $value,
          'after' => $array2[$key]
        ];
      }
    }

    foreach ($array2 as $key => $value) {
      $currentPath = array_merge($path, [$key]);
      $currentPathStr = implode('.', $currentPath);

      if (in_array($currentPathStr, $ignoreKeys)) {
        continue; // Skip keys that should be ignored
      }

      if (!array_key_exists($key, $array1)) {
        $changes['added'][$currentPathStr] = $value;
      } elseif (is_array($value) && is_array($array1[$key])) {
        $result = self::arrayDelta(
          array1: $array1[$key],
          array2: $value,
          ignoreKeys: $ignoreKeys,
          compare: $compare,
          path: $currentPath,
        );

        $changes = [
          'added' => array_merge($changes['added'] ?? [], $result['added'] ?? []),
          'modified' => array_merge($changes['modified'] ?? [], $result['modified'] ?? []),
          'removed' => array_merge($changes['removed'] ?? [], $result['removed'] ?? []),
        ];
      }
    }


    return array_filter($changes);
  }
}
