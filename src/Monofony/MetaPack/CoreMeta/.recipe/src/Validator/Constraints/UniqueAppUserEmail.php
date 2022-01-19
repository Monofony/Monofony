<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class UniqueAppUserEmail extends Constraint
{
    public string $message = 'sylius.user.email.unique';
}
