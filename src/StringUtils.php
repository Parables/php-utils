<?php

namespace Parables\Utils;

trait StringUtils
{
  public static function normalizeWhitespace(string $string = ''): string
  {
    return preg_replace('/\s+/', ' ', trim($string));
  }

  public static function slugify(string $string = '', bool $toLowerCase = true): string
  {
    $string = preg_replace('/[^a-zA-Z0-9\s\-\_]/', '', $string);
    $string = str_replace(' ', '-', $string);
    $string = preg_replace('/[-_]+/', '-', $string);
    $string = trim(string: $string, characters: '\-');

    return $toLowerCase ? strtolower($string) : $string;
  }

  public static function words(string $string = ''): array
  {
    $string = self::slugify(string: $string, toLowerCase: false);
    $words = explode(separator: '-', string: $string);
    $words = array_map(
      function (string $word) use ($words) {
        return ucfirst(
          string: count($words) > 1
            ? strtolower($word)
            : $word
        );
      },
      $words
    );

    return $words;
  }

  public static function capitalize(string $string = ''): string
  {
    return implode(separator: ' ', array: self::words(string: $string));
  }

  public static function pascalCase(string $string = ''): string
  {
    $string = implode(separator: '', array: self::words(string: $string));

    return self::isAllUpperCase(string: $string)
      ? ucfirst(strtolower(string: $string))
      : $string;
  }

  public static function isAllUpperCase(string $string): bool
  {
    return preg_match(pattern: '/^[^a-z]*$/', subject: $string);
  }

  public static function camelCase(string $string = ''): string
  {
    $string = lcfirst(self::pascalCase(string: $string));

    return $string;
  }

  public static function snakeCase(string $string = ''): string
  {
    return preg_replace('/[-_]+/', '_', slugify($string));
  }

  public static function kebabCase(string $string): string
  {
    return str_replace(search: '_', replace: '-', subject: self::snakeCase($string));
  }

  public static function isUrl(string $url = ''): bool
  {
    return filter_var($url, FILTER_VALIDATE_URL) !== false;
  }

  public static function isValidUrl(string $url): bool
  {
    try {
      // Attempt to parse the URL using PHP's built-in functions
      $parsedUrl = parse_url($url);

      // Ensure required components are present
      $requiredComponents = ['scheme', 'host'];
      foreach ($requiredComponents as $component) {
        if (!isset($parsedUrl[$component])) {
          return false;
        }
      }

      // Validate the hostname using a regular expression
      $hostnameRegex = '/^[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/';
      if (!preg_match($hostnameRegex, $parsedUrl['host'])) {
        return false;
      }

      // Consider using filter_var for additional validation if needed
      $filterResult = filter_var($url, FILTER_VALIDATE_URL);
      if ($filterResult === false) {
        return false;
      }

      return true;
    } catch (\Exception $e) {
      // Catch any parsing errors and return false
      return false;
    }
  }
}
