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
            $_key = $callback($key);

            if (in_array(needle: "$prefix.$key", haystack: $preserveKeys)) {
                $_key = $key;
            }

            if (is_array($value)) {
                $result[$_key] = self::arrayKeysTransform(
                    payload: $value,
                    callback: $callback,
                    preserveKeys: $preserveKeys,
                    prefix: empty($prefix) ? "$key" : "$prefix.$key",
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
            if (! in_array(needle: $_item, haystack: $uniqueStr)) {
                $uniqueStr[] = $_item;
                $unique[] = $item;
            }
        }

        return $unique;
    }


    public static function arrayWrap(mixed $value): array
    {
        return match(true){
            is_null($value) => [],
            is_array($value) => $value,
            default => [$value],
        };
    }
}
