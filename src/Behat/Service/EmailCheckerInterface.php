<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Behat\Service;

interface EmailCheckerInterface
{
    /**
     * @param string $recipient
     *
     * @return bool
     */
    public function hasRecipient(string $recipient): bool;

    /**
     * @param string $message
     * @param string $recipient
     *
     * @return bool
     */
    public function hasMessageTo(string $message, string $recipient): bool;

    /**
     * @param string $recipient
     *
     * @return int
     */
    public function countMessagesTo(string $recipient): int;

    /**
     * @return string
     */
    public function getSpoolDirectory(): string;
}
