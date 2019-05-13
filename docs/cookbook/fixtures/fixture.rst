How to configure your fixture options
=====================================

Now you have to create a fixture service. This defines options you can use on `fixtures bundle configurations yaml files`_.

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

In this file we have only one custom option which is the article title.
Now Register it on Symfony on ``config/services/fixtures.yaml``

.. code-block:: yaml

    # config/services/fixtures.yaml

    services:
        _defaults:
            autowire: true
            tags: [sylius_fixtures.fixture]

        # [...]

        App\Fixture\ArticleFixture:
                arguments:
                    $exampleFactory: '@App\Fixture\Factory\ArticleExampleFactory'

.. _fixtures bundle configurations yaml files: https://github.com/Monofony/SymfonyStarter/blob/master/config/packages/sylius_fixtures.yaml
