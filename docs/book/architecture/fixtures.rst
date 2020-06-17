.. index::
   single: Fixtures

Fixtures
========

Fixtures are used mainly for testing, but also for having your website in a certain state, having defined data
- they ensure that there is a fixed environment in which your application is working.

.. note::

   The way Fixtures are designed in Monofony is well described in the `FixturesBundle documentation <https://github.com/Sylius/SyliusFixturesBundle/blob/master/docs/index.md>`_.

What are the available fixtures in Monofony?
--------------------------------------------

To check what fixtures are defined in Monofony run:

.. code-block:: bash

   $ php bin/console sylius:fixtures:list

How to load Monofony fixtures?
------------------------------

The recommended way to load the predefined set of Monofony fixtures is here:

.. code-block:: bash

   $ php bin/console sylius:fixtures:load

What data is loaded by fixtures in Monofony?
--------------------------------------------

All files that serve for loading fixtures of Monofony are placed in the ``App/Fixture/*`` directory.

And the specified data for fixtures is stored in the
``config/packages/sylius_fixtures.yaml`` file.
