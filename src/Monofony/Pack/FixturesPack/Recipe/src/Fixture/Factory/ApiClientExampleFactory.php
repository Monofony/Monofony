<?php

declare(strict_types=1);

namespace App\Fixture\Factory;

use FOS\OAuthServerBundle\Model\ClientInterface;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApiClientExampleFactory extends AbstractExampleFactory
{
    /** @var ClientManagerInterface */
    private $clientManager;

    /** @var \Faker\Generator */
    private $faker;

    /** @var OptionsResolver */
    private $optionsResolver;

    public function __construct(ClientManagerInterface $clientManager)
    {
        $this->clientManager = $clientManager;

        $this->faker = \Faker\Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): ClientInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var ClientInterface $client */
        $client = $this->clientManager->createClient();

        $client->setRandomId($options['random_id']);
        $client->setSecret($options['secret']);

        $client->setAllowedGrantTypes($options['allowed_grant_types']);

        return $client;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('random_id', function (Options $options): int {
                return $this->faker->unique()->randomNumber(8);
            })
            ->setDefault('secret', function (Options $options): string {
                return $this->faker->uuid;
            })
            ->setDefault('allowed_grant_types', [])
            ->setAllowedTypes('allowed_grant_types', ['array'])
        ;
    }
}
