How to add a new context?
=========================

Thanks to symfony autowiring, most of your contexts are ready to use.

But if you need to manually route an argument, it is needed to add a service in to one of a following files ``cli.yaml``/``hook.yaml``/``setup.yaml``/``transform.yaml``/``ui.yaml`` in ``src/Behat/Resources/config/services/contexts/`` folder:

.. code-block:: yaml

    App\Behat\Context\CONTEXT_CATEGORY\CONTEXT_NAME:
        arguments:
            $specificArgument: App\SpecificArgument

Then you can use it in your suite configuration:

.. code-block:: yaml

    default:
        suites:
            SUITE_NAME:
                contexts:
                    - 'App\Behat\Context\CONTEXT_CATEGORY\CONTEXT_NAME'
                filters:
                    tags: "@SUITE_TAG"

.. note::

    The context categories are usually one of ``cli``, ``hook``, ``setup``, ``transform``, ``ui`` and, as you can guess, they are corresponded to files name mentioned above.
