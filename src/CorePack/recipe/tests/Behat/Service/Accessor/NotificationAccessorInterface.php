<?php



namespace App\Tests\Behat\Service\Accessor;

use App\Tests\Behat\NotificationType;

interface NotificationAccessorInterface
{
    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return NotificationType
     */
    public function getType();
}
