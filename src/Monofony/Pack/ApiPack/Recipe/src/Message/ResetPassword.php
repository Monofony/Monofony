<?php

/*
 * This file is part of monofony.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Validator\Constraints as Assert;

final class ResetPassword
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }
}
