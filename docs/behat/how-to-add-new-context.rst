How to run add new context
==========================

.. code-block:: php

    <?php

    namespace AppBundle\Behat;

    class SupplierContext extends DefaultContext
    {
        // ...
    }

Then you can use it in your suite configuration:

.. code-block:: yaml

    default:
        suites:
            SUITE_NAME:
                contexts:
                    - AppBundle\Behat\CONTEXTNAMEContext
                filters:
                    tags: "@SUITE_TAG"