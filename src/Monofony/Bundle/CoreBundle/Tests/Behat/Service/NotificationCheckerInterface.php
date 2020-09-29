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

namespace Monofony\Bundle\CoreBundle\Tests\Behat\Service;

use App\Tests\Behat\Exception\NotificationExpectationMismatchException;
use App\Tests\Behat\NotificationType;

interface NotificationCheckerInterface
{
    /**
     *
     * @throws NotificationExpectationMismatchException
     */
    public function checkNotification(string $message, NotificationType $type);
}
