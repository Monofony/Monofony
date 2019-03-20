How to design entities with phpspec
===================================

Lets configure an Article entity with a title and an author.
Title is a simple string and author implements CustomerInterface.

.. warning::

    By default, phpspec on Monofony is configured with code coverage.
    :doc:`Learn how to configure phpspec with code coverage </cookbook/bdd/phpspec/how-to-configure-phpspec-with-code-coverage>` or :doc:`disable code coverage </cookbook/bdd/phpspec/how-to-disable-phpspec-code-coverage>`.

Generate phpspec for your entity
--------------------------------

.. code-block:: bash

    $ vendor/bin/phpspec describe App/Entity/Article

    $ # with phpdbg installed
    $ phpdbg -qrr vendor/bin/phpspec describe App/Entity/Article

.. code-block:: php

    # spec/src/App/Entity/Article.php

    namespace spec\App\Entity;

    use App\Entity\Article;
    use PhpSpec\ObjectBehavior;
    use Prophecy\Argument;

    class ArticleSpec extends ObjectBehavior
    {
        function it_is_initializable()
        {
            $this->shouldHaveType(Article::class);
        }
    }

Run phpspec and do not fear Red
-------------------------------

To run phpspec for our Article entity, run this command:

.. code-block:: bash

    $ vendor/bin/phpspec run spec/App/Entity/ArticleSpec.php -n
    $
    $ # with phpdbg installed
    $ phpdbg -qrr vendor/bin/phpspec run spec/App/Entity/ArticleSpec.php -n

And be happy with your first error message with red color.

.. note::

    You can simply run all the phpspec tests by running `vendor/bin/phpspec run -n`


Create a minimal Article class
------------------------------

.. code-block:: php

    # src/App/Entity/Article.php

    namespace App\Entity;

    class Article
    {
    }


Rerun phpspec and see a beautiful green color.

Specify it implements sylius resource interface
-----------------------------------------------

.. code-block:: php

    function it_implements_sylius_resource_interface(): void
    {
        $this->shouldImplement(ResourceInterface::class);
    }

.. warning::

    And Rerun phpspec, DO NOT FEAR RED COLOR!
    It's important to check that you write code which solves your specifications.

Solve this on your entity
-------------------------

.. code-block:: php

    # src/App/Entity/Article.php

    namespace App\Entity;

    use Sylius\Component\Resource\Model\ResourceInterface;

    class Article implements ResourceInterface
    {
        use IdentifiableTrait;
    }

.. warning::

    Rerun phpspec again and check this specification is solved.

Specify title behaviours
------------------------

.. code-block:: php

    function it_has_no_title_by_default(): void
    {
        $this->getTitle()->shouldReturn(null);
    }

    function its_title_is_mutable(): void
    {
        $this->setTitle('This documentation is so great');
        $this->getTitle()->shouldReturn('This documentation is so great');
    }

.. warning::

    Don't forget to rerun phpspec on each step.

Add title on Article entity
---------------------------

.. code-block:: php

    # src/App/Entity/Article.php

    /**
     * @var string|null
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

Specify author of the article
-----------------------------

.. code-block:: php

    # spec/src/App/Entity/Article.php

    use Sylius\Component\Customer\Model\CustomerInterface;

    // [...]

    function its_author_is_mutable(CustomerInterface $author): void
    {
        $this->setAuthor($author);
        $this->getAuthor()->shouldReturn($author);
    }

Add author on your entity
-------------------------

.. code-block:: php

    # src/App/Entity/Article.php

    // [...]

    /**
     * @var CustomerInterface|null
     */
    private $author;

    // [...]

    /**
     * @return CustomerInterface|null
     */
    public function getAuthor(): ?CustomerInterface
    {
        return $this->author;
    }

    /**
     * @param CustomerInterface|null $author
     */
    public function setAuthor(?CustomerInterface $author): void
    {
        $this->author = $author;
    }

That's all to design your first entity!
