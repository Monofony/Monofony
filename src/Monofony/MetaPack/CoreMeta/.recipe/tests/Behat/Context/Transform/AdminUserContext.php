<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Monofony\Contracts\Core\Model\User\AdminUserInterface;

final class AdminUserContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    public function __construct(SharedStorageInterface $sharedStorage)
    {
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Transform /^(I|my)$/
     */
    public function getLoggedAdminUser(): AdminUserInterface
    {
        return $this->sharedStorage->get('administrator');
    }
}
