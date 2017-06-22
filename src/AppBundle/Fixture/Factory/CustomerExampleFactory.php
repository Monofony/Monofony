<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Fixture\Factory;

use AppBundle\Entity\AdminUser;
use AppBundle\Entity\Customer;
use AppBundle\Fixture\OptionsResolver\LazyOption;
use Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Corentin Nicole <corentin@mobizel.com>
 */
class CustomerExampleFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
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
     * CustomerExampleFactory constructor.
     *
     * @param FactoryInterface $customerFactory
     */
    public function __construct(FactoryInterface $customerFactory)
    {
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

        /** @var Customer $customer */
        $customer = $this->customerFactory->createNew();
        $customer->setEmail($options['email']);
        $customer->setFirstName($options['first_name']);
        $customer->setLastName($options['last_name']);
        $customer->setBirthday($options['birthday']);
        $customer->setPhoneNumber($options['phone_number']);

        return $customer;
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
            ->setDefault('first_name', function (Options $options) {
                return $this->faker->firstName;
            })
            ->setDefault('last_name', function (Options $options) {
                return $this->faker->lastName;
            })
            ->setDefault('birthday', function (Options $options) {
                return $this->faker->dateTimeBetween('-90 years','-10 years');
            })
            ->setDefault('phone_number', function (Options $options) {
                return $this->faker->phoneNumber;
            })
        ;
    }
}
