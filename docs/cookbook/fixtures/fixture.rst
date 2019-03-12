Configure your fixture options
==============================

Now you have to create a fixture service to define few options for this resource.

.. code-block:: php

    namespace App\Fixture;

    use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

    class ArticleFixture extends AbstractResourceFixture
    {
        /**
         * {@inheritdoc}
         */
        public function getName(): string
        {
            return 'article';
        }

        /**
         * {@inheritdoc}
         */
        protected function configureResourceNode(ArrayNodeDefinition $resourceNode)
        {
            $resourceNode
                ->children()
                    ->scalarNode('title')->cannotBeEmpty()->end()
            ;
        }
    }

Register it on Symfony on ``config/services/fixtures.yml``

.. code-block:: yaml

    services:
        _defaults:
            autowire: true
            tags: [sylius_fixtures.fixture]

        # [...]

        App\Fixture\ArticleFixture:
                arguments:
                    $exampleFactory: '@App\Fixture\Factory\ArticleExampleFactory'
