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

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\UnitOfWork;
use App\Entity\Customer\CustomerInterface;
use Sylius\Component\User\Model\UserInterface;

/**
 * Keeps user's username synchronized with email.
 */
final class DefaultUsernameORMListener
{
    /**
     * @param OnFlushEventArgs $onFlushEventArgs
     */
    public function onFlush(OnFlushEventArgs $onFlushEventArgs): void
    {
        $entityManager = $onFlushEventArgs->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();

        $this->processEntities($unitOfWork->getScheduledEntityInsertions(), $entityManager, $unitOfWork);
        $this->processEntities($unitOfWork->getScheduledEntityUpdates(), $entityManager, $unitOfWork);
    }

    /**
     * @param array                  $entities
     * @param EntityManagerInterface $entityManager
     */
    private function processEntities($entities, EntityManagerInterface $entityManager, UnitOfWork $unitOfWork): void
    {
        foreach ($entities as $customer) {
            if (!$customer instanceof CustomerInterface) {
                continue;
            }

            /** @var UserInterface $user */
            $user = $customer->getUser();

            if (null === $user) {
                continue;
            }

            if ($customer->getEmail() === $user->getUsername() && $customer->getEmailCanonical() === $user->getUsernameCanonical()) {
                continue;
            }

            $user->setUsername($customer->getEmail());
            $user->setUsernameCanonical($customer->getEmailCanonical());

            /** @var ClassMetadata $userMetadata */
            $userMetadata = $entityManager->getClassMetadata(get_class($user));
            $unitOfWork->recomputeSingleEntityChangeSet($userMetadata, $user);
        }
    }
}
