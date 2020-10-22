<?php

namespace App\Formatter;

final class StringInflector
{
    public static function nameToCode(string $value): string
    {
        return str_replace([' ', '-'], '_', $value);
    }

    public static function nameToLowercaseCode(string $value): string
    {
        return strtolower(self::nameToCode($value));
    }

    public static function nameToUppercaseCode(string $value): string
    {
        return strtoupper(self::nameToCode($value));
    }

    private function __construct()
    {
    }
}
