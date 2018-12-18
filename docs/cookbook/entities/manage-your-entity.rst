Manage your new entity on the admin panel
=========================================

To add a new grid, create a new grid configuration file in ``config/packages/grids/backend/`` and import this to sylius_grid configuration file

Create a new grid configuration file
------------------------------------

``config/packages/grids/backend/article.yml``

.. code-block:: yaml

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

``config/packages/sylius_grid.yaml``

.. code-block:: yaml

    imports:
      - { resource: 'grids/backend/article.yml' }
      - { resource: 'grids/backend/admin_user.yml' }
      - { resource: 'grids/backend/customer.yml' }
