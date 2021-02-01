<?php

declare(strict_types=1);

namespace App\Message;

use App\Validator\Constraints as CustomConstraints;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterAppUser
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="sylius.customer.email.not_blank")
     * @Assert\Email(mode="strict", message="sylius.customer.email.invalid")
     * @Assert\Length(
     *     max=254,
     *     maxMessage="sylius.customer.email.max"
     * )
     * @CustomConstraints\UniqueAppUserEmail()
     *
     * @Serializer\Groups({"customer:write"})
     */
    public $email;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(message="sylius.user.plainPassword.not_blank")
     * @Assert\Length(
     *     min=4,
     *     minMessage="sylius.user.password.min",
     *     max=254,
     *     maxMessage="sylius.user.password.max"
     * )
     *
     * @Serializer\Groups({"customer:write"})
     */
    public $password;

    /**
     * @var string|null
     *
     * @Serializer\Groups({"customer:write"})
     */
    public $firstName;

    /**
     * @var string|null
     *
     * @Serializer\Groups({"customer:write"})
     */
    public $lastName;

    /**
     * @var string|null
     *
     * @Serializer\Groups({"customer:write"})
     */
    public $phoneNumber;

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
