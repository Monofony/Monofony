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

namespace Monofony\Bridge\Behat\Exception;

use Monofony\Bridge\Behat\NotificationType;

final class NotificationExpectationMismatchException extends \RuntimeException
{
    public function __construct(
        NotificationType $expectedType,
        $expectedMessage,
        $code = 0,
        \Exception $previous = null
    ) {
        $message = sprintf(
            'Expected *%s* notification with a "%s" message was not found',
            (string) $expectedType,
            $expectedMessage
        );

        parent::__construct($message, $code, $previous);
    }
}
