<?php



namespace App\Tests\Behat\Service;

use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

final class SharedSecurityService implements SharedSecurityServiceInterface
{
    /**
     * @var SecurityServiceInterface
     */
    private $adminSecurityService;

    /**
     * {@inheritdoc}
     */
    public function __construct(SecurityServiceInterface $adminSecurityService)
    {
        $this->adminSecurityService = $adminSecurityService;
    }

    /**
     * {@inheritdoc}
     */
    public function performActionAsAdminUser(UserInterface $adminUser, callable $action)
    {
        $this->performActionAs($this->adminSecurityService, $adminUser, $action);
    }

    /**
     * @param SecurityServiceInterface $securityService
     * @param UserInterface            $user
     * @param callable                 $action
     */
    private function performActionAs(SecurityServiceInterface $securityService, UserInterface $user, callable $action): void
    {
        try {
            $token = $securityService->getCurrentToken();
        } catch (TokenNotFoundException $exception) {
            $token = null;
        }

        $securityService->logIn($user);
        $action();

        if (null === $token) {
            $securityService->logOut();

            return;
        }

        $securityService->restoreToken($token);
    }
}
