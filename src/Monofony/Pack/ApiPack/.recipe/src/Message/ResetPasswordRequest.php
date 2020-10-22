<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Validator\Constraints as Assert;

final class ResetPasswordRequest
{
    /**
     * @var string
     *
     * @Assert\NotBlank(message="sylius.user.email.not_blank")
     */
    public $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
