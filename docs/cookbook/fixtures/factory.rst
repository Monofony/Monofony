How to configure a fixture factory
==================================

First you have to create a fixture factory. This service is responsible to create new instance of the resource and handle options.
This allows to combine random and custom data on your data fixtures.

.. code-block:: php

    namespace App\Fixture\Factory;

    use App\Entity\Article;
    use Monofony\Plugin\FixturesPlugin\Fixture\Factory\AbstractExampleFactory;
    use Sylius\Component\Resource\Factory\FactoryInterface;
    use Symfony\Component\OptionsResolver\Options;
    use Symfony\Component\OptionsResolver\OptionsResolver;

    final class ArticleExampleFactory extends AbstractExampleFactory
    {
        /** @var FactoryInterface */
        private $articleFactory;

        /** @var \Faker\Generator */
        private $faker;

        /** @var OptionsResolver */
        private $optionsResolver;

        public function __construct(FactoryInterface $articleFactory)
        {
            $this->articleFactory = $articleFactory;

            $this->faker = \Faker\Factory::create();
            $this->optionsResolver = new OptionsResolver();

            $this->configureOptions($this->optionsResolver);
        }

        /**
         * {@inheritdoc}
         */
        protected function configureOptions(OptionsResolver $resolver): void
        {
            $resolver
                ->setDefault('title', function (Options $options) {
                    return ucfirst($this->faker->words(3, true));
                });
        }

        /**
         * {@inheritdoc}
         */
        public function create(array $options = []): Article
        {
            $options = $this->optionsResolver->resolve($options);

            /** @var Article $article */
            $article = $this->articleFactory->createNew();
            $article->setTitle($options['title']);

            return $article;
        }
    }

Thanks to services configuration, your new service is already registered and ready to use:

.. code-block:: bash

    $ bin/console debug:container App\Fixture\Factory\ArticleExampleFactory
