<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ResetPasswordRequest
{
    #[NotBlank(message: 'sylius.user.email.not_blank')]
    #[Groups(groups: ['customer:write'])]
    public ?string $email = null;

    public function __construct(?string $email = null)
    {
        $this->email = $email;
    }
}
