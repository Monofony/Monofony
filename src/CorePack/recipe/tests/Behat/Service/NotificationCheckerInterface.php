<?php



namespace App\Tests\Behat\Service;

use App\Tests\Behat\Exception\NotificationExpectationMismatchException;
use App\Tests\Behat\NotificationType;

interface NotificationCheckerInterface
{
    /**
     * @param string           $message
     * @param NotificationType $type
     *
     * @throws NotificationExpectationMismatchException
     */
    public function checkNotification($message, NotificationType $type);
}
