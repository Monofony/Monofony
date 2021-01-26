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

use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

final class ResetPassword
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank
     *
     * @Serializer\Groups({"customer:write"})
     */
    public $password;

    public function __construct(string $password = null)
    {
        $this->password = $password;
    }
}
