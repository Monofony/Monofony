How to configure phpspec with code coverage
===========================================

By default, phpspec on Monofony is configured with code coverage which needs xdebug or phpdbg installed.
Thus you have two options:
* install xdebug
* install phpdbg (easier and faster)


.. note::

    But if you don't need that feature, :doc:`disable code coverage </cookbook/bdd/phpspec/how-to-disable-phpspec-code-coverage>`.


Install phpdbg
--------------

.. code-block:: bash

    $ # on linux
    $ sudo apt-get install php7.2-phpdbg
    $
    $ # on max
    $ brew install php72-phpdbg
