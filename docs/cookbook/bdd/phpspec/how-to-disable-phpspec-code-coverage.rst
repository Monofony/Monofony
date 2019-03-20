How to disable phpspec code coverage
====================================

.. code-block:: bash

    $ cp phpspec.yml.dist phpspec

And just comment the content

.. code-block:: yaml

    # extensions:
    #    LeanPHP\PhpSpec\CodeCoverage\CodeCoverageExtension: ~
