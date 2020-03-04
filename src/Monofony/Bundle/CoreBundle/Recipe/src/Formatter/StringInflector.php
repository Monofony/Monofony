<?php

namespace App\Formatter;

final class StringInflector
{
    /**
     * @param string $value
     *
     * @return string
     */
    public static function nameToCode($value)
    {
        return str_replace([' ', '-'], '_', $value);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function nameToLowercaseCode($value)
    {
        return strtolower(self::nameToCode($value));
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public static function nameToUppercaseCode($value)
    {
        return strtoupper(self::nameToCode($value));
    }

    private function __construct()
    {
    }
}
