<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ChangeAppUserPassword;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\User\Model\CredentialsHolderInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\PasswordUpdaterInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class ChangeAppUserPasswordHandler implements MessageHandlerInterface
{
    public function __construct(
        private PasswordUpdaterInterface $passwordUpdater,
        private EntityManagerInterface $entityManager,
        private Security $security,
    ) {
    }

    public function __invoke(ChangeAppUserPassword $message): void
    {
        $user = $this->security->getUser();
        Assert::notNull($user);

        if (!$user instanceof CredentialsHolderInterface) {
            return;
        }

        $user->setPlainPassword($message->newPassword);

        $this->passwordUpdater->updatePassword($user);

        $this->entityManager->flush();
    }
}
