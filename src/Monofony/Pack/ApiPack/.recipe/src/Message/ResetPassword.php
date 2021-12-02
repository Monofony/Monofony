<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class ResetPassword
{
    /**
     * @Assert\NotBlank
     * @Serializer\Groups({"customer:write"})
     */
    public ?string $password = null;

    public function __construct(?string $password = null)
    {
        $this->password = $password;
    }
}
