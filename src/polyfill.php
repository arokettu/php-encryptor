<?php

/**
 * @see https://wiki.php.net/rfc/add_str_begin_and_end_functions
 *
 * At the time of coding neither PHP 7.4 nor known polyfill lib is available
 */

if (!function_exists('str_ends_with')) {
    function str_ends_with(string $haystack, string $needle): bool
    {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
}

if (!function_exists('str_ends_with_ci')) {
    function str_ends_with_ci(string $haystack, string $needle): bool
    {
        return str_ends_with(strtolower($haystack), strtolower($needle));
    }
}
