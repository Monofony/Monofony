<?php

declare(strict_types=1);

namespace App\Validator\Initializer;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Symfony\Component\Validator\ObjectInitializerInterface;

final class CustomerInitializer implements ObjectInitializerInterface
{
    public function __construct(private CanonicalizerInterface $canonicalizer)
    {
    }

    public function initialize(object $object): void
    {
        if ($object instanceof CustomerInterface) {
            $emailCanonical = $this->canonicalizer->canonicalize($object->getEmail());
            $object->setEmailCanonical($emailCanonical);
        }
    }
}
