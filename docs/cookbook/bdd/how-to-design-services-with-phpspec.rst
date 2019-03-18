How to design services with phpspec
===================================

Lets configure an Article factory to create an article for an author.
This Author implements CustomerInterface.

Generate phpspec for your entity factory
----------------------------------------

.. code-block:: bash

    $ vendor/bin/phpspec describe App/Factory/ArticleFactory

    $ # with phpdbg installed
    $ phpdbg -qrr vendor/bin/phpspec describe App/Factory/ArticleFactory

Run phpspec and do not fear Red
-------------------------------

To run phpspec for our Article factory, run this command:

.. code-block:: bash

    $ vendor/bin/phpspec run spec/App/Factory/ArticleFactory.php -n
    $
    $ # with phpdbg installed
    $ phpdbg -qrr vendor/bin/phpspec run spec/App/Factory/ArticleFactorySpec.php -n

And be happy with your first error message with red color.

.. note::

    You can simply run all the phpspec tests by running `vendor/bin/phpspec run -n`

Create a minimal article factory class
--------------------------------------

.. code-block:: php

    # src/Factory/ArticleFactory.php

    namespace App\Factory;

    class ArticleFactory
    {
    }

Rerun phpspec and see a beautiful green color.

Specify it implements sylius factory interface
______________________________________________

.. code-block:: php

    # spec/App/Factory/ArticleFactorySpec.php

    function it_implements_sylius_factory_interface(): void
    {
        $this->shouldImplement(FactoryInterface::class);
    }

.. warning::

    Don't forget to rerun phpspec on each step.

Solve this on your factory
--------------------------

.. code-block:: php

    # src/Factory/ArticleFactory.php

    namespace App\Factory;

    use Sylius\Component\Resource\Factory\FactoryInterface;

    class ArticleFactory implements FactoryInterface
    {
        /**
         * {@inheritdoc}
         */
        public function createNew()
        {
        }
    }

Specify it creates articles
-----------------------------------------

.. code-block:: php

    # spec/App/Factory/ArticleFactorySpec.php

    // [...]

    function its_creates_articles(): void
    {
        $article = $this->createNew();

        $article->shouldImplement(Article::class);
    }

Solve this on your factory
--------------------------

.. code-block:: php

    # src/Factory/ArticleFactory.php

    namespace App\Factory;

    use Sylius\Component\Resource\Factory\FactoryInterface;

    class ArticleFactory implements FactoryInterface
    {
        /** @var string */
        private $className;

        public function __construct(string $className)
        {
            $this->className = $className;
        }

        /**
         * {@inheritdoc}
         */
        public function createNew(): Article
        {
            return new $this->className();
        }
    }

Running this step will throw this exception:

.. code-block:: php

    exception [err:ArgumentCountError("Too few arguments to function App\Factory\ArticleFactory::__construct(), 0 passed and exactly 1 expected")] has been thrown.

To add arguments on constructor, go back to your factory spec and add these lines:

.. code-block:: php

    # spec/App/Factory/ArticleFactorySpec.php

    namespace spec\App\Factory;

    use App\Entity\Article;
    use App\Factory\ArticleFactory;
    use PhpSpec\ObjectBehavior;
    use Sylius\Component\Resource\Factory\FactoryInterface;

    class ArticleFactorySpec extends ObjectBehavior
    {
        function let()
        {
            $this->beConstructedWith(Article::class);
        }

        // [...]
    }

Rerun phpspec and it should be solved.

.. note::

    Here you pass a string, but you often need to pass objects on constructor. You just have to add them on arguments of the let method and don't forget to use typehints.


Here is an example with object arguments:

.. code-block:: php

    function let(FactoryInterface $factory)
    {
        $this->beConstructedWith($factory);
    }

Specify it creates articles for an author
-----------------------------------------

.. code-block:: php

    # spec/App/Factory/ArticleFactorySpec.php

    // [...]

    function its_creates_articles_for_an_author(CustomerInterface $author): void
    {
        $article = $this->createForAuthor($author);

        $article->getAuthor()->shouldReturn($author);
    }

Add this method on your factory
-------------------------------

.. code-block:: php

    # src/Factory/ArticleFactory.php

    // [...]

    /**
     * @param CustomerInterface $author
     *
     * @return Article
     */
    public function createForAuthor(CustomerInterface $author): Article
    {
        $article = $this->createNew();
        $article->setAuthor($author);

        return $article;
    }

And that's all to specify this simple article factory.
