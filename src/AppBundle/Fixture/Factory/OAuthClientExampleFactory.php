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

use AppBundle\Entity\Address;
use AppBundle\Entity\OAuth\Client;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Corentin Nicole
 */
class OAuthClientExampleFactory extends AbstractExampleFactory
{
    /**
     * @var FactoryInterface
     */
    private $oauthClientFactory;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @param FactoryInterface $oauthClientFactory
     */
    public function __construct(FactoryInterface $oauthClientFactory)
    {
        $this->oauthClientFactory = $oauthClientFactory;

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
            ->setDefault('random_id', function (Options $options) {
                return $this->faker->sha1;
            })
            ->setDefault('secret', function (Options $options) {
                return $this->faker->sha1;
            });
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = [])
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var Client $client */
        $client = $this->oauthClientFactory->createNew();
        $client->setRandomId($options['random_id']);
        $client->setSecret($options['secret']);
        $client->setAllowedGrantTypes(['password','refresh_token','token']);

        return $client;
    }
}
