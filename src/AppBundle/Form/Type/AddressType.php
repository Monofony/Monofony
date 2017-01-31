<?php

/*
 * This file is part of AppName.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class AddressType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('street', TextType::class, [
                'label' => 'sylius.ui.street',
            ])
            ->add('postcode', TextType::class, [
                'label' => 'sylius.ui.postcode',
            ])
            ->add('city', TextType::class, [
                'label' => 'sylius.ui.city',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_address';
    }
}
