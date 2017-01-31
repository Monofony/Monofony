<?php

/*
 * This file is part of rd_042_s_monofony.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Extension;

use AppBundle\Form\Type\User\UserRegistrationType;
use Sylius\Bundle\CustomerBundle\Form\Type\CustomerProfileType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Corentin Nicole <corentin@mobizel.com>
 */
final class CustomerProfileTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user',UserRegistrationType::class);
        $builder->remove('gender');
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return CustomerProfileType::class;
    }
}
