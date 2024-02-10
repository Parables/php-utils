# php-utils

A set of handy php functions

## Usage

All `Util::method()` are also exposed as global functions.
In order to avoid conflicts with already declared functions
with the same name, the global functions are wrapped in an
`if (! function_exists('fn_name')) {` block.

```php
// StringUtils

normalize_whitespace(...$args)
capitalize(...$args)
instance_or_default(...$args)
slugify(...$args)
words(...$args)
is_all_upper_case(...$args)
pascal_case(...$args)
camel_case(...$args)
snake_case(...$args)
kebab_case(...$args)
excel_date_to_php_date(...$args)
array_flatten(...$args)
array_keys_transform(...$args)
array_unique_value(...$args)
is_url(...$args)
is_valid_url(...$args)
```

### String Utils

1. `normalizeWhitespace(string $str = '')`

Removes extra whitespace and trims the string.

```php
$str = "  This string \n has \t extra  \v   spaces .   ";
$normalizedStr = Utils::normalizeWhitespace($str);
// $normalizedStr = "This string has extra spaces .";
```

2. `capitalize(string $str = '')`

Capitalizes first letter of each word, lowercase rest.

```php
$str = "this SENTENCE needs CAPITALIZATION!";
$capitalizedStr = Utils::capitalize($str);
// $capitalizedStr = "This Sentence Needs Capitalization";
```

3. `slugify(string $str = '', bool $toLower = true)`

Converts to URL-friendly format with dashes/underscores.
Optional toLower controls lowercase conversion.

```php
$str = "My Awesome Product Name!";
$slug = Utils::slugify($str);
// $slug = "my-awesome-product-name";

$slugWithUppercase = Utils::slugify($str, false);
// $slugWithUppercase = "My-Awesome-Product-Name";
```

4. `words(string $str = '')`

Splits into an array of words, preserving capitalization for single words.

```php
$str = "This is a sentence with multiple words.";
$words = Utils::words($str);
// $words = ["This", "Is", "A", "Sentence", "With", "Multiple", "Words"]; 
```

5. `isAllUpperCase(string $str)`

Checks if all characters are uppercase.

```php
$str = "ALL UPPERCASE";
$isAllUpper = Utils::isAllUpperCase($str); // true

$str = "Not All Uppercase";
$isAllUpper = Utils::isAllUpperCase($str); // false
```

6. `pascalCase(string $str = '')`

Converts to PascalCase (all words start with uppercase).

```php
$str = "this is a string";
$pascalCase = Utils::pascalCase($str);
// $pascalCase = "ThisIsString";
```

7. `camelCase(string $str = '')`

Converts to camelCase (first word lowercase, others uppercase).

```php
$str = "This is a string";
$camelCase = Utils::camelCase($str);
// $camelCase = "thisIsAString";
```

8. `snakeCase(string $str = '')`

Converts to snake_case (lowercase with underscores).

```php
$str = "This is a string";
$snakeCase = Utils::snakeCase($str);
// $snakeCase = "this_is_a_string";
```

9. `kebabCase(string $str)`

Converts to kebab-case (lowercase with hyphens).

```php
$str = "This is a string";
$kebabCase = Utils::kebabCase($str);
// $kebabCase = "this-is-a-string";
```

10. `isUrl(string $url)`

Basic URL validation using built-in functions.

```php
$url = "https://www.example.com";
$isUrlValid = Utils::isUrl($url); // true

$url = "invalid-url";
$isUrlValid = Utils::isUrl($url); // false
```

11. `isValidUrl(string $url)`

Performs more rigorous URL validation with parsing and hostname checks.

```php
$url = "https://www.example.com";
$isValidUrl = Utils::isValidUrl($url); // true

$url = "invalid-url";
$isValidUrl = Utils::isValidUrl($url); // false
```
