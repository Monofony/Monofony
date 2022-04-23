<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;

class UserContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    public function __construct(SharedStorageInterface $sharedStorage)
    {
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Transform /^(I|my|he|his|she|her|"this user")$/
     */
    public function getLoggedUser(): mixed
    {
        return $this->sharedStorage->get('user');
    }
}
