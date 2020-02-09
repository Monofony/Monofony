<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventListener;

use App\Entity\Customer\CustomerInterface;
use Sylius\Bundle\UserBundle\EventListener\PasswordUpdaterListener as BasePasswordUpdaterListener;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\GenericEvent;

final class PasswordUpdaterListener extends BasePasswordUpdaterListener
{
    /**
     * @param GenericEvent $event
     */
    public function customerUpdateEvent(GenericEvent $event): void
    {
        $customer = $event->getSubject();

        if (!$customer instanceof CustomerInterface) {
            throw new UnexpectedTypeException(
                $customer,
                CustomerInterface::class
            );
        }

        if (null !== $user = $customer->getUser()) {
            $this->updatePassword($user);
        }
    }
}
