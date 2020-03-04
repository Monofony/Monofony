<?php

namespace App\Form\Type\Customer;

use App\Entity\Customer\Customer;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class CustomerRegistrationType extends AbstractResourceType
{
    public function __construct()
    {
        parent::__construct(Customer::class, [
            'sylius',
            'sylius_user_registration',
            'sylius_customer_profile',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('firstName', TextType::class, [
                'label' => 'sylius.form.customer.first_name',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'sylius.form.customer.last_name',
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
                'label' => 'sylius.form.customer.phone_number',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return CustomerSimpleRegistrationType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sylius_customer_registration';
    }
}
