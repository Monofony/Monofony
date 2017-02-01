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

use AppBundle\Form\EventSubscriber\CustomerRegistrationFormSubscriber;
use AppBundle\Form\EventSubscriber\UserRegistrationFormSubscriber;
use AppBundle\Form\Type\User\UserRegistrationType;
use Sylius\Bundle\CustomerBundle\Form\Type\CustomerType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Corentin Nicole <corentin@mobizel.com>
 */
final class CustomerTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',UserRegistrationType::class)
            ->remove('gender')
            ->remove('group')
            ->addEventSubscriber(new UserRegistrationFormSubscriber());
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'validation_groups' => function (FormInterface $form) use ($resolver) {
                    $validationGroups = ['sylius'];
                    $data = $form->getData();
                    if ($data && !$data->getId()) {
                        $validationGroups[] = 'sylius_user_create';
                    }
                    return $validationGroups;
                },
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return CustomerType::class;
    }
}
