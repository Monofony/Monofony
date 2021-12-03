<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ResetPassword
{
    #[NotBlank]
    #[Groups(groups: ['customer:write'])]
    public ?string $password = null;

    public function __construct(?string $password = null)
    {
        $this->password = $password;
    }
}
