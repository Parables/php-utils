<?php

namespace Parables\Utils;

trait ClassUtils
{
    public static function instanceOrDefault(
        mixed $instance,
        mixed $value,
        mixed $defaultValue = null
    ): mixed {
        return match (true) {
            $value instanceof $instance => $value,
            default => $defaultValue,
        };

    }
}
