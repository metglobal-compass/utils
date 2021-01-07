<?php

use Metglobal\Utils\Collection;
use Metglobal\Utils\Hlp;
use Metglobal\Utils\Optional;
use Metglobal\Utils\Str;

if (!function_exists('optional')) {
    /**
     * Allow arrow-syntax access of optional objects by using a higher-order
     * proxy object. The eliminates some need of ternary and null coalesce
     * operators.
     *
     * @param mixed|null $value
     *
     * @return Optional
     */
    function optional($value): Optional
    {
        return new Optional($value);
    }
}

if (!function_exists('class_basename')) {
    /**
     * Getting class base (short) name from FQCN or object.
     *
     * @param mixed $class
     *
     * @return string
     */
    function class_basename($class): string
    {
        return Hlp::classBasename($class);
    }
}

if (!function_exists('str_interpolate')) {
    /**
     * Interpolate replacement values into the message.
     *
     * @return string
     */
    function str_interpolate(string $message, array $context): string
    {
        return Str::interpolate($message, $context);
    }
}

if (!function_exists('str_random')) {
    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @return string
     */
    function str_random(int $length = 8): string
    {
        return Str::random($length);
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('collect')) {
    /**
     * Create a collection from the given value.
     *
     * @param mixed $value
     *
     * @return Collection
     */
    function collect($value = null): Collection
    {
        return new Collection($value);
    }
}
