<?php

declare(strict_types=1);

namespace App\Fixture;

use App\Fixture\Factory\AppUserExampleFactory;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class AppUserFixture extends AbstractResourceFixture
{
    public function __construct(ObjectManager $objectManager, AppUserExampleFactory $appUserExampleFactory)
    {
        parent::__construct($objectManager, $appUserExampleFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'app_user';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureResourceNode(ArrayNodeDefinition $resourceNode)
    {
        $resourceNode
            ->children()
                ->scalarNode('email')->cannotBeEmpty()->end()
                ->booleanNode('enabled')->end()
                ->scalarNode('password')->cannotBeEmpty()->end()
                ->scalarNode('first_name')->cannotBeEmpty()->end()
                ->scalarNode('last_name')->cannotBeEmpty()->end()
                ->scalarNode('customer')->cannotBeEmpty()->end()
        ;
    }
}
