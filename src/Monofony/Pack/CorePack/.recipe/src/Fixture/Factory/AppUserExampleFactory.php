<?php

declare(strict_types=1);

namespace App\Fixture\Factory;

use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppUserExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $appUserFactory;

    /**
     * @var FactoryInterface
     */
    private $customerFactory;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * AppUserExampleFactory constructor.
     */
    public function __construct(FactoryInterface $appUserFactory, FactoryInterface $customerFactory)
    {
        $this->appUserFactory = $appUserFactory;
        $this->customerFactory = $customerFactory;

        $this->faker = \Faker\Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = [])
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var CustomerInterface $customer */
        $customer = $this->customerFactory->createNew();
        $customer->setEmail($options['email']);
        $customer->setFirstName($options['first_name']);
        $customer->setLastName($options['last_name']);

        /** @var AppUserInterface $user */
        $user = $this->appUserFactory->createNew();
        $user->setUsername($options['username']);
        $user->setPlainPassword($options['password']);
        $user->setEnabled($options['enabled']);
        $user->addRole('ROLE_USER');

        foreach ($options['roles'] as $role) {
            $user->addRole($role);
        }

        $user->setCustomer($customer);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('username', function (Options $options) {
                return $this->faker->userName;
            })

            ->setDefault('email', function (Options $options) {
                return $this->faker->email;
            })

            ->setDefault('first_name', function (Options $options) {
                return $this->faker->firstName;
            })

            ->setDefault('last_name', function (Options $options) {
                return $this->faker->lastName;
            })

            ->setDefault('enabled', true)
            ->setAllowedTypes('enabled', 'bool')

            ->setDefault('password', 'password123')

            ->setDefault('roles', [])
            ->setAllowedTypes('roles', 'array')
        ;
    }
}
