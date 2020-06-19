<?php

declare(strict_types=1);

namespace App\Fixture;

use App\Fixture\Factory\ApiClientExampleFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Monofony\Plugin\FixturesPlugin\Fixture\AbstractResourceFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ApiClientFixture extends AbstractResourceFixture
{
    public function __construct(ObjectManager $objectManager, ApiClientExampleFactory $apiClientExampleFactory)
    {
        parent::__construct($objectManager, $apiClientExampleFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'api_client';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode)
    {
        $resourceNode
            ->children()
                ->scalarNode('random_id')->cannotBeEmpty()->end()
                ->scalarNode('secret')->cannotBeEmpty()->end()
                ->arrayNode('allowed_grant_types')->scalarPrototype()->cannotBeEmpty()->defaultValue(['password', 'access_token', 'refresh_token'])->end();
    }
}
