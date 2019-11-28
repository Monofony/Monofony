<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Fixture;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ApiClientFixture extends AbstractResourceFixture
{
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
                ->arrayNode('allowed_grant_types')->scalarPrototype()->cannotBeEmpty()->defaultValue([])->end()
        ;
    }
}
