How to run add new context
==========================

.. note::

    A context is an object which includes several methods used by behat to transform sentences into actions. You can create many contexts as you want.

To add a new context to Behat container it is needed to add a context object

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