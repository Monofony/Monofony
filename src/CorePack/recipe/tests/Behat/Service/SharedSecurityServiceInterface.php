<?php



namespace App\Tests\Behat\Service;

use Sylius\Component\User\Model\UserInterface;

interface SharedSecurityServiceInterface
{
    /**
     * @param UserInterface $adminUser
     * @param callable      $action
     */
    public function performActionAsAdminUser(UserInterface $adminUser, callable $action);
}
