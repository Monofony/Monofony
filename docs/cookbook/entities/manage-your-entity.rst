How to manage your new entity on the admin panel
================================================

To add a new grid, create a new grid configuration file in ``config/packages/grids/backend/`` and import this to sylius_grid configuration file

Create a new grid configuration file
------------------------------------

.. code-block:: yaml

    # config/packages/grids/backend/article.yaml

    sylius_grid:
        grids:
            app_backend_article:
                driver:
                    name: doctrine/orm
                    options:
                        class: "%app.model.article.class%"
                sorting:
                    title: asc
                fields:
                    title:
                        type: string
                        label: sylius.ui.title
                        sortable: ~
                filters:
                    search:
                        type: string
                        label: sylius.ui.search
                        options:
                            fields: [title]
                actions:
                    main:
                        create:
                            type: create
                    item:
                        update:
                            type: update
                        delete:
                            type: delete

Import this to sylius_grid configuration file
---------------------------------------------

.. code-block:: yaml

    # config/packages/sylius_grid.yaml

    imports:
        - { resource: 'grids/backend/article.yaml' }
        - { resource: 'grids/backend/admin_user.yaml' }
        - { resource: 'grids/backend/customer.yaml' }

Learn More
----------

* `Configuring grid in sylius documentation`_
* `The whole configuration reference in sylius documentation`_

.. _The whole configuration reference in sylius documentation: https://docs.sylius.com/en/latest/components_and_bundles/bundles/SyliusGridBundle/configuration.html
.. _Configuring grid in sylius documentation: https://docs.sylius.com/en/latest/components_and_bundles/bundles/SyliusGridBundle/your_first_grid.html
