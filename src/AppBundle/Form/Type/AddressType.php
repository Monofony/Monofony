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

use AppBundle\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ])
            ->add('date', DateType::class, [
                'label' => 'sylius.ui.date',
                'mapped' => false,
                'required' => false,
            ])
            ->add('dateTime', DateTimeType::class, [
                'label' => 'sylius.ui.date',
                'mapped' => false,
                'required' => false,
                'widget' => 'single_text',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Address::class,
        ));
    }
}
