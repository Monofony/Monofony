How to configure your first resource
====================================

As an example we will take an **Article entity**.


.. code-block:: php

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Sylius\Component\Resource\Model\ResourceInterface;
    use Symfony\Component\Validator\Constraints as Assert;

    /**
     * @ORM\Entity
     * @ORM\Table(name="app_article")
     */
    class Article implements ResourceInterface
    {
        use IdentifiableTrait;

        /**
         * @var string|null
         *
         * @ORM\Column(type="string")
         *
         * @Assert\NotBlank()
         */
        private $title;

        /**
         * @return string|null
         */
        public function getTitle(): ?string
        {
            return $this->title;
        }

        /**
         * @param string|null $title
         */
        public function setTitle(?string $title): void
        {
            $this->title = $title;
        }
    }

You now have to add it on Sylius Resource configuration.

.. code-block:: yaml

    # config/packages/sylius_resource.yaml

    sylius_resource:
        resources:
            app.article:
                classes:
                    model: App\Entity\Article
                    form: App\Form\Type\ArticleType
            app.oauth_client:
                classes:
                    model: App\Entity\OAuth\Client

.. warning::

    Don't forget to synchronize your database using Doctrine Migrations.

You can use these two commands to generate and synchronize your database.

.. code-block:: bash

    $ bin/console doctrine:migrations:diff
    $ bin/console doctrine:migrations:migrate

Learn More
----------

* `Sylius Resource Bundle`_ documentation
* `Doctrine migrations`_ documentation

.. _`Sylius Resource Bundle`: https://docs.sylius.com/en/latest/components_and_bundles/bundles/SyliusResourceBundle/configuration.html
.. _`Doctrine migrations`: https://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html
