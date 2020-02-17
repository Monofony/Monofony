<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Service;

use App\Tests\Behat\Exception\NotificationExpectationMismatchException;
use App\Tests\Behat\NotificationType;
use App\Tests\Behat\Service\Accessor\NotificationAccessorInterface;

final class NotificationChecker implements NotificationCheckerInterface
{
    /**
     * @var NotificationAccessorInterface
     */
    private $notificationAccessor;

    /**
     * @param NotificationAccessorInterface $notificationAccessor
     */
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

        throw new NotificationExpectationMismatchException(
            $type,
            $message,
            $this->notificationAccessor->getType(),
            $this->notificationAccessor->getMessage()
        );
    }

    /**
     * @param NotificationType $type
     *
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
