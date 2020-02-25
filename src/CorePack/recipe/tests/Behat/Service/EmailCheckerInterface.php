<?php



declare(strict_types=1);

namespace App\Tests\Behat\Service;

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
