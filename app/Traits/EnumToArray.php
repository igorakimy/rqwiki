<?php

declare(strict_types=1);

namespace App\Traits;

trait EnumToArray
{
    /**
     * Get array of enum names.
     *
     * @return array
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * Get array of enum values.
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get array combination of enum values and names.
     *
     * @return array
     */
    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }
}
