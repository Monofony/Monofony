<?php

/*
 * This file is part of mz_067_s_ccpa_thermotool.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomConstraints;

final class RegisterAppUser
{
    /**
     * @var string
     *
     * @Assert\NotBlank(message="sylius.customer.email.not_blank")
     * @Assert\Email(mode="strict", message="sylius.customer.email.invalid")
     * @Assert\Length(
     *     max=254,
     *     maxMessage="sylius.customer.email.max"
     * )
     * @CustomConstraints\UniqueAppUserEmail()
     */
    public $email;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="sylius.user.plainPassword.not_blank")
     * @Assert\Length(
     *     min=4,
     *     minMessage="sylius.user.password.min",
     *     max=254,
     *     maxMessage="sylius.user.password.max"
     * )
     */
    public $password;

    /** @var string|null */
    public $firstName;

    /**
     * @var string|null */
    public $lastName;

    /** @var string|null */
    public $phoneNumber;

    public function __construct(
        string $email,
        string $password,
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
