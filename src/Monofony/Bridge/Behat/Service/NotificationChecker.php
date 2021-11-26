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

final class NotificationChecker implements NotificationCheckerInterface
{
    private NotificationAccessorInterface $notificationAccessor;

    public function __construct(NotificationAccessorInterface $notificationAccessor)
    {
        $this->notificationAccessor = $notificationAccessor;
    }

    /**
     * {@inheritdoc}
     */
    public function checkNotification($message, NotificationType $type)
    {
        if ($this->hasType($type) && $this->hasMessage($message)) {
            return;
        }

        throw new NotificationExpectationMismatchException($type, $message, $this->notificationAccessor->getType(), $this->notificationAccessor->getMessage());
    }

    /**
     * @return bool
     */
    private function hasType(NotificationType $type)
    {
        return $type === $this->notificationAccessor->getType();
    }

    /**
     * @param string $message
     *
     * @return bool
     */
    private function hasMessage($message)
    {
        return false !== strpos($this->notificationAccessor->getMessage(), $message);
    }
}
