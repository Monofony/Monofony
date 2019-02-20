How to add a new page object?
=============================

Sylius uses a solution inspired by ``SensioLabs/PageObjectExtension``, which provides an infrastructure to create
pages that encapsulates all the user interface manipulation in page objects.

To create a new page object it is needed to add a service in Behat container in ``src/Behat/Resources/services/pages.yml`` file:

.. code-block:: yaml

    App\Behat\Page\PAGE_NAME:
        parent: app.behat.page
        public: false

.. note::

    There are some boilerplates for common pages, which you may use. The available parents are ``app.behat.page`` (``FriendsOfBehat\PageObjectExtension\Page\Page``)
    and ``app.behat.symfony_page`` (``FriendsOfBehat\PageObjectExtension\Page\SymfonyPage``). It is not required for a page to extend any class as
    pages are POPOs (Plain Old PHP Objects).

Then you will need to add that service as a regular argument in context service.

The simplest Symfony-based page looks like:

.. code-block:: php

    use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

    class LoginPage extends SymfonyPage
    {
        public function getRouteName()
        {
            return 'sylius_user_security_login';
        }
    }
