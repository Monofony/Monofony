<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Service;

use App\Behat\Exception\NotificationExpectationMismatchException;
use App\Behat\NotificationType;


/**
 * @author Łukasz Chruściel <lukasz.chrusciel@lakion.com>
 */
interface NotificationCheckerInterface
{
    /**
     * @param string $message
     * @param NotificationType $type
     *
     * @throws NotificationExpectationMismatchException
     */
    public function checkNotification($message, NotificationType $type);
}
