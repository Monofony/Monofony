<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\Constraints as CustomConstraints;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterAppUser
{
    /**
     * @CustomConstraints\UniqueAppUserEmail()
     */
    #[NotBlank(message: 'sylius.customer.email.not_blank')]
    #[Email(mode: 'strict', message: 'sylius.customer.email.invalid')]
    #[Length(max: 254, maxMessage: 'sylius.customer.email.max')]
    #[Groups(groups: ['customer:write'])]
    public ?string $email = null;

    #[NotBlank(message: 'sylius.user.plainPassword.not_blank')]
    #[Length(min: 4, minMessage: 'sylius.user.password.min', max: 254, maxMessage: 'sylius.user.password.max')]
    #[Groups(groups: ['customer:write'])]
    public ?string $password = null;

    #[Groups(groups: ['customer:write'])]
    public ?string $firstName = null;

    #[Groups(groups: ['customer:write'])]
    public ?string $lastName = null;

    #[Groups(groups: ['customer:write'])]
    public ?string $phoneNumber = null;

    public function __construct(
        ?string $email = null,
        ?string $password = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $phoneNumber = null
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
    }
}
