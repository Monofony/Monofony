How to configure your first resource
====================================

As an example we will take an **Article entity**.


.. code-block:: php

    /*
     * This file is part of AppName.
     *
     * (c) Monofony
     *
     * For the full copyright and license information, please view the LICENSE
     * file that was distributed with this source code.
     */

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use JMS\Serializer\Annotation as JMS;
    use Sylius\Component\Resource\Model\ResourceInterface;
    use Symfony\Component\Validator\Constraints as Assert;

    /**
     * @ORM\Entity
     * @ORM\Table(name="app_article")
     *
     * @JMS\ExclusionPolicy("all")
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
         *
         * @JMS\Expose
         * @JMS\Groups({"Default", "Detailed"})
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

    sylius_resource:
        resources:
            app.article:
                classes:
                    model: App\Entity\Article
                    form: App\Form\Type\ArticleType
            app.oauth_client:
                classes:
                    model: App\Entity\OAuth\Client

.. note::

    You can learn more from `Sylius Resource Bundle`_ documentation.

.. _`Sylius Resource Bundle`: https://docs.sylius.com/en/latest/components_and_bundles/bundles/SyliusResourceBundle/configuration.html
