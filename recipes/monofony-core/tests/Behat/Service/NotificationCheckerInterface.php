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
