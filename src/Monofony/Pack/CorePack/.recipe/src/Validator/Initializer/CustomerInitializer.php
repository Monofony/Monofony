<?php

declare(strict_types=1);

namespace App\Validator\Initializer;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Symfony\Component\Validator\ObjectInitializerInterface;

final class CustomerInitializer implements ObjectInitializerInterface
{
    private CanonicalizerInterface $canonicalizer;

    public function __construct(CanonicalizerInterface $canonicalizer)
    {
        $this->canonicalizer = $canonicalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function initialize($object)
    {
        if ($object instanceof CustomerInterface) {
            $emailCanonical = $this->canonicalizer->canonicalize($object->getEmail());
            $object->setEmailCanonical($emailCanonical);
        }
    }
}
