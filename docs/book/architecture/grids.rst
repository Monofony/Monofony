.. index::
    single: Grids

Grids
=====

A grid is the way objects of a desired entity are displayed on its index view.

Create a Grid
-------------

To create a grid, you have to create a yaml file in ``app/config/app/sylius/grids`` and to add this file in the ``sylius_grid.yml``.

.. code-block:: yaml

    sylius_grid:
        grids:
            app_backend_address:
                driver:
                    name: doctrine/orm
                    options:
                        class: "%app.model.address.class%"
                sorting:
                    city: asc
                fields:
                    street:
                        type: string
                        label: sylius.ui.street
                        sortable: ~
                    postcode:
                        type: string
                        label: sylius.ui.postcode
                        sortable: ~
                    city:
                        type: string
                        label: sylius.ui.city
                        sortable: ~
                filters:
                    search:
                        type: string
                        label: sylius.ui.search
                        options:
                            fields: [street, postcode, city]
                actions:
                    main:
                        create:
                            type: create
                    item:
                        update:
                            type: update
                        delete:
                            type: delete

Generate the routing
--------------------

SyliusResourceBundle allows to generate a default CRUD interface including the grid we have just defined. Just put this in your routing configuration!
To learn more about routing, go to :doc:`Routing documentation </book/architecture/routing>`.

.. code-block:: yaml

    app_backend_address:
        resource: |
            alias: app.address
            section: backend
            except: ['show']
            redirect: index
            grid: app_backend_address
            vars:
                all:
                    subheader: app.ui.manage_addresses
                    templates:
                        form: backend/address/_form.html.twig
                index:
                    icon: map
            templates: :backend/crud
        type: sylius.resource

The Grid Configuration Reference
--------------------------------

Here you will find all configuration options of ``sylius_grid``.

.. code-block:: yaml

    sylius_grid:
        grids:
            app_user: # Your grid name
                driver:
                    name: doctrine/orm
                    options:
                        class: "%app.model.user%"
                sorting:
                    name: asc
                limits: [10, 25, 50, 100]
                fields:
                    name:
                        type: twig # Type of field
                        label: Name # Label
                        path: . # dot means a whole object
                        sortable: true
                        position: 100
                        options:
                            template: :Grid/Column:_name.html.twig # Only twig column
                            vars:
                                labels: # a template of how does the label look like
                        enabled: true
                filters:
                    name:
                        type: string # Type of filter
                        label: app.ui.name
                        enabled: true
                        template: ~
                        position: 100
                        options:
                            fields: { }
                        form_options:
                            type: contains # type of string filtering option, if you one to have just one
                        default_value: ~
                    enabled:
                        type: boolean # Type of filter
                        label: app.ui.enabled
                        enabled: true
                        template: ~
                        position: 100
                        options:
                            field: enabled
                        form_options: { }
                        default_value: ~
                    date:
                        type: date # Type of filter
                        label: app.ui.created_at
                        enabled: true
                        template: ~
                        position: 100
                        options:
                            field: createdAt
                        form_options: { }
                        default_value: ~
                    channel:
                        type: entity # Type of filter
                        label: app.ui.channel
                        enabled: true
                        template: ~
                        position: 100
                        options:
                            fields: [channel]
                        form_options:
                            class: "%app.model.channel%"
                        default_value: ~
                actions:
                    main:
                        create:
                            type: create
                            label: sylius.ui.create
                            enabled: true
                            icon: ~
                            position: 100
                    item:
                        update:
                            type: update
                            label: sylius.ui.edit
                            enabled: true
                            icon: ~
                            position: 100
                            options: { }
                        delete:
                            type: delete
                            label: sylius.ui.delete
                            enabled: true
                            icon: ~
                            position: 100
                            options: { }
                        show:
                            type: show
                            label: sylius.ui.show
                            enabled: true
                            icon: ~
                            position: 100
                            options:
                                link:
                                    route: app_user_show
                                    parameters:
                                        id: resource.id
                        archive:
                            type: archive
                            label: sylius.ui.archive
                            enabled: true
                            icon: ~
                            position: 100
                            options:
                                restore_label: sylius.ui.restore
                    subitem:
                        addresses:
                            type: links
                            label: sylius.ui.manage_addresses
                            options:
                                icon: cubes
                                links:
                                    index:
                                        label: sylius.ui.list_addresses
                                        icon: list
                                        route: app_admin_user_address_index
                                        visible: resource.hasAddress
                                        parameters:
                                            userId: resource.id
                                    create:
                                        label: sylius.ui.generate
                                        icon: random
                                        route: app_admin_user_address_create
                                        parameters:
                                            userId: resource.id

Learn More
----------

.. note::

   The way Grids are used in AppName is well described in the `GridBundle documentation <http://docs.sylius.org/en/latest/components_and_bundles/bundles/SyliusGridBundle/index.html?highlight=Grid>`_.
