<?php



declare(strict_types=1);

namespace App\Tests\Behat\Context\Transform;

use App\Entity\User\AdminUserInterface;
use App\Tests\Behat\Service\SharedStorageInterface;
use Behat\Behat\Context\Context;

final class AdminUserContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    public function __construct(SharedStorageInterface $sharedStorage)
    {
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Transform /^(I|my)$/
     */
    public function getLoggedAdminUser(): ?AdminUserInterface
    {
        return $this->sharedStorage->get('administrator');
    }
}
