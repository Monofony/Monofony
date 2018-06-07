<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Service;

use AppBundle\Behat\Exception\NotificationExpectationMismatchException;
use AppBundle\Behat\NotificationType;


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
