<?php

namespace Metglobal\Utils;

class Str
{
    /**
     * Generate random string.
     *
     * @throws \Exception
     */
    public static function random(int $length = 8): string
    {
        return substr(bin2hex(random_bytes($length)), 0, $length);
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string|array $needles
     */
    public static function starts(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ('' !== $needle && substr($haystack, 0, strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param string|string[] $needles
     */
    public static function ends(string $haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ('' !== $needle && substr($haystack, -strlen($needle)) === (string) $needle) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     */
    public static function contains($haystack, $needles): bool
    {
        foreach ((array) $needles as $needle) {
            if ('' != $needle && false !== mb_strpos($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate a slug.
     */
    public static function slug(string $string): string
    {
        // replace non letter or digits by -
        $string = preg_replace('~[^\pL\d]+~u', '-', $string);

        // transliterate
        $string = iconv('ISO-8859-1', 'UTF-8//TRANSLIT', $string);

        // remove unwanted characters
        $string = preg_replace('~[^-\w]+~', '', $string);

        // trim
        $string = trim($string, '-');

        // remove duplicate -
        $string = preg_replace('~-+~', '-', $string);

        // lowercase
        $string = strtolower($string);

        return $string;
    }

    /**
     * Interpolate a message with context.
     */
    public static function interpolate(string $message, array $context = []): string
    {
        // build a replacement array with braces around the context keys
        $replace = [];
        foreach ($context as $key => $value) {
            // check that the value can be casted to string
            if (!is_array($value) && (!is_object($value) || method_exists($value, '__toString'))) {
                $replace['{'.$key.'}'] = $value;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }

    /**
     * Replace char(s) by any character.
     *
     * @param string $string
     * @param int    $first
     * @param int    $last
     * @param string $replace
     *
     * @return string
     */
    public static function replaceCharWith($string = '', $first = 0, $last = 0, $replace = '*')
    {
        if ($last <= 0) {
            $last = strlen($string) + $last;

            if ($first < 0) {
                $first = strlen($string) + $first;
            }
        }

        $begin = substr($string, 0, $first);
        $middle = str_repeat($replace, strlen(substr($string, $first, $last - $first)));
        $end = substr($string, $last);
        $stars = $begin.$middle.$end;

        return $stars;
    }
}
