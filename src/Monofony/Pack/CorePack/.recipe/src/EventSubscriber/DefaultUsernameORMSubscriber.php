<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\UnitOfWork;
use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use Sylius\Component\User\Model\UserInterface;

/**
 * Keeps user's username synchronized with email.
 */
final class DefaultUsernameORMSubscriber implements EventSubscriber
{
    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::onFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $onFlushEventArgs): void
    {
        $entityManager = $onFlushEventArgs->getEntityManager();
        $unitOfWork = $entityManager->getUnitOfWork();

        $this->processEntities($unitOfWork->getScheduledEntityInsertions(), $entityManager, $unitOfWork);
        $this->processEntities($unitOfWork->getScheduledEntityUpdates(), $entityManager, $unitOfWork);
    }

    private function processEntities(array $entities, EntityManagerInterface $entityManager, UnitOfWork $unitOfWork): void
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
