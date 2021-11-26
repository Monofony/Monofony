<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Monofony\Bridge\Behat;

final class NotificationType
{
    private string $value;

    private static array $types = [];

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * @return NotificationType
     */
    public static function failure()
    {
        return static::getTyped('failure');
    }

    /**
     * @return NotificationType
     */
    public static function success()
    {
        return static::getTyped('success');
    }

    /**
     * @param string $type
     *
     * @return NotificationType
     */
    private static function getTyped($type)
    {
        if (!isset(static::$types[$type])) {
            static::$types[$type] = new self($type);
        }

        return static::$types[$type];
    }
}
