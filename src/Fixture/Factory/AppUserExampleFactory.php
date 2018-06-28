<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Fixture\Factory;

use App\Entity\AppUser;
use App\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Corentin Nicole <corentin@mobizel.com>
 */
class AppUserExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $appUserFactory;

    /**
     * @var RepositoryInterface
     */
    private $customerRepository;

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
     *
     * @param FactoryInterface $appUserFactory
     * @param RepositoryInterface $customerRepository
     */
    public function __construct(FactoryInterface $appUserFactory, RepositoryInterface $customerRepository)
    {
        $this->appUserFactory = $appUserFactory;
        $this->customerRepository = $customerRepository;

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

        /** @var AppUser $user */
        $user = $this->appUserFactory->createNew();

        $user->setUsername($options['email']);
        $user->setEmail($options['email']);
        $user->setPlainPassword($options['password']);
        $user->setEnabled($options['enabled']);
        $user->setCustomer($options['customer']);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('email', function (Options $options) {
                return $this->faker->email;
            })
            ->setDefault('enabled', true)
            ->setAllowedTypes('enabled', 'bool')
            ->setDefault('password', 'password')
            ->setDefault('api', false)
            ->setDefined('first_name')
            ->setDefined('last_name')
            ->setDefined('customer')
            ->setAllowedTypes('customer', ['null', 'string', CustomerInterface::class])
            ->setNormalizer('customer', LazyOption::findOneBy($this->customerRepository, 'email'))
        ;
    }
}
