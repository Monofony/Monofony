<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class ChangeAppUserPassword implements AppUserIdAwareInterface
{
    /** @var int|null */
    public $appUserId;

    /**
     * @var string|null
     *
     * @Assert\NotBlank
     * @SecurityAssert\UserPassword(message="sylius.user.plainPassword.wrong_current")
     *
     * @Serializer\Groups({"customer:password:write"})
     */
    public $currentPassword;

    /**
     * @var string|null
     *
     * @Assert\NotBlank
     *
     * @Serializer\Groups({"customer:password:write"})
     */
    public $newPassword;

    public function __construct(?string $currentPassword = null, ?string $newPassword = null)
    {
        $this->currentPassword = $currentPassword;
        $this->newPassword = $newPassword;
    }

    public function getAppUserId(): ?int
    {
        return $this->appUserId;
    }

    public function setAppUserId(?int $appUserId): void
    {
        $this->appUserId = $appUserId;
    }
}
