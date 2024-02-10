<?php

namespace Parables\Utils;

class Utils
{
    use ArrayUtils;
    use ClassUtils;
    use DateUtils;
    use StringUtils;

    public static function configOrEnv(
        string $configKey,
        string $envKey,
        mixed $default = null,
    ) {
        $value = $default;
        try {
            $value = config(key: $configKey, default: $default);
        } catch (\Throwable $th) {
            try {
                $value = env(key: $envKey, default: $default);
            } catch (\Throwable $th) {
                $value = $default;
            }
        } finally {
            return $value;
        }
    }
}
