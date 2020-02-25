<?php



namespace App\Tests\Behat\Exception;

use App\Tests\Behat\NotificationType;

final class NotificationExpectationMismatchException extends \RuntimeException
{
    public function __construct(
        NotificationType $expectedType,
        $expectedMessage,
        NotificationType $actualType,
        $actualMessage,
        $code = 0,
        \Exception $previous = null
    ) {
        $message = sprintf(
            "Expected *%s* notification with a \"%s\" message was not found.\n *%s* notification with a \"%s\" message has been found.",
            $expectedType,
            $expectedMessage,
            $actualType,
            $actualMessage
        );

        parent::__construct($message, $code, $previous);
    }
}
