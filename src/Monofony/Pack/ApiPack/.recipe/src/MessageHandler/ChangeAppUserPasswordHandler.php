<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ChangeAppUserPassword;
use Doctrine\ORM\EntityManagerInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Sylius\Component\User\Security\PasswordUpdaterInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;

final class ChangeAppUserPasswordHandler implements MessageHandlerInterface
{
    private $passwordUpdater;
    private $userRepository;
    private $entityManager;

    public function __construct(
        PasswordUpdaterInterface $passwordUpdater,
        UserRepositoryInterface $appUserRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->passwordUpdater = $passwordUpdater;
        $this->userRepository = $appUserRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(ChangeAppUserPassword $message): void
    {
        /** @var AppUserInterface|null $user */
        $user = $this->userRepository->find($message->getAppUserId());

        Assert::notNull($user);

        $user->setPlainPassword($message->newPassword);

        $this->passwordUpdater->updatePassword($user);

        $this->entityManager->flush();
    }
}
