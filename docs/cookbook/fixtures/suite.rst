How to use it on your suite
===========================

.. code-block:: yaml

    # config/sylius/fixtures.yaml

    sylius_fixtures:
        suites:
            default:
                listeners:
                    orm_purger: ~
                    logger: ~

                fixtures:
                    [...]

                    article:
                        options:
                            random: 10
                            custom:
                                -
                                    title: "Awesome article"

it will generates 10 random articles and one custom with title ``Awesome article``.
