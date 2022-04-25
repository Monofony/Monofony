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

namespace Monofony\Bridge\Behat\Service;

use Monofony\Bridge\Behat\Exception\NotificationExpectationMismatchException;
use Monofony\Bridge\Behat\NotificationType;
use Monofony\Bridge\Behat\Service\Accessor\NotificationAccessorInterface;
use Webmozart\Assert\Assert;

final class NotificationChecker implements NotificationCheckerInterface
{
    public function __construct(private NotificationAccessorInterface $notificationAccessor)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function checkNotification($message, NotificationType $type)
    {
        foreach ($this->notificationAccessor->getMessageElements() as $messageElement) {
            if (
                str_contains($messageElement->getText(), $message) &&
                $messageElement->hasClass($this->resolveClass($type))
            ) {
                return;
            }
        }

        throw new NotificationExpectationMismatchException($type, $message);
    }

    private function resolveClass(NotificationType $type): string
    {
        $typeClassMap = [
            'failure' => 'negative',
            'info' => 'info',
            'success' => 'positive',
        ];

        Assert::keyExists($typeClassMap, $type->__toString());

        return $typeClassMap[$type->__toString()];
    }
}
