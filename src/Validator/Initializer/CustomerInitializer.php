<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Validator\Initializer;

use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Symfony\Component\Validator\ObjectInitializerInterface;

final class CustomerInitializer implements ObjectInitializerInterface
{
    /**
     * @var CanonicalizerInterface
     */
    private $canonicalizer;

    /**
     * @param CanonicalizerInterface $canonicalizer
     */
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
