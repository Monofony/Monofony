How to run tests
================

Run selenium-server-standalone
------------------------------

.. code-block:: bash

    bin/selenium-server-standalone -Dwebdriver.chrome.driver=$PWD/bin/chromedriver

Run all tests
-------------

.. code-block:: bash

    vendor/bin/behat

Run only one scenario
---------------------

.. code-block:: bash

    vendor/bin/behat --name="My Scenario Name"

Run only non-javascript tests
-----------------------------

.. code-block:: bash

    vendor/bin/behat --tags ~javascript

Run only non-javascript tests and also exclude todo tests
---------------------------------------------------------

.. code-block:: bash

    vendor/bin/behat --tags ~javascript --tags ~todo

.. note::

    This can be useful for continuous integration.