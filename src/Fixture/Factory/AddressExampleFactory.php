<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Fixture\Factory;

use App\Entity\Address;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jan Góralski <jan.goralski@lakion.com>
 */
class AddressExampleFactory extends AbstractExampleFactory
{
    /**
     * @var FactoryInterface
     */
    private $addressFactory;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @param FactoryInterface $addressFactory
     */
    public function __construct(FactoryInterface $addressFactory)
    {
        $this->addressFactory = $addressFactory;

        $this->faker = \Faker\Factory::create('fr_FR');
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('street', function (Options $options) {
                return $this->faker->streetAddress;
            })
            ->setDefault('city', function (Options $options) {
                return $this->faker->city;
            })
            ->setDefault('postcode', function (Options $options) {
                return $this->faker->postcode;
            });
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = [])
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var Address $address */
        $address = $this->addressFactory->createNew();
        $address->setStreet($options['street']);
        $address->setCity($options['city']);
        $address->setPostcode($options['postcode']);

        return $address;
    }
}
