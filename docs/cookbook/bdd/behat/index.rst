How to use Behat to design your features
----------------------------------------

.. note::

    This section is based on the great `Sylius documentation <http://docs.sylius.com>`_.

Behaviour driven development is an approach to software development process that provides software development and management teams
with shared tools and a shared process to collaborate on software development. The awesome part of BDD is its ubiquitous language,
which is used to describe the software in English-like sentences of domain specific language.

The application's behaviour is described by scenarios, and those scenarios are turned into automated test suites with tools such as Behat.

Sylius behaviours are fully covered with Behat scenarios. There are more than 1200 scenarios in the Sylius suite, and if you want
to understand some aspects of Sylius better, or are wondering how to configure something, we strongly recommend
reading them. They can be found in the ``features/`` directory of the Sylius/Sylius repository.

We use `FriendsOfBehat/SymfonyExtension`_ to integrate Behat with Symfony.

.. toctree::
    :hidden:

    basic-usage
    how-to-add-new-context
    how-to-add-new-page
    how-to-define-new-suite
    how-to-use-transformers
    how-to-change-behat-application-base-url

.. include:: /cookbook/bdd/behat/map.rst.inc

Learn more
----------

.. note::

    To learn more, read the `Behat documentation <http://behat.org/en/latest/guides.html>`_.

.. _FriendsOfBehat/SymfonyExtension: https://github.com/FriendsOfBehat/SymfonyExtension
