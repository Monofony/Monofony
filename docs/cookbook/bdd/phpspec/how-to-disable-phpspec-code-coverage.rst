.. rst-class:: outdated

.. danger::

   This is an outdated documentation please read the new `Monofony documentation`_ instead.

How to disable phpspec code coverage
====================================

.. code-block:: bash

    $ cp phpspec.yml.dist phpspec

And just comment the content

.. code-block:: yaml

    # extensions:
    #    LeanPHP\PhpSpec\CodeCoverage\CodeCoverageExtension: ~

.. _Monofony documentation: https://docs.monofony.com
