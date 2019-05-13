How to configure backend routes
===============================

To configure backend routes for your entity, you have to create a new file on backend routes folder ``config/routes/backend``.

Let’s configure our “Article” routes as an example.

.. code-block:: yaml

    # config/routes/backend/article.yaml

    app_backend_article:
        resource: |
            alias: app.article
            section: backend
            except: ['show']
            redirect: update
            grid: app_backend_article
            vars:
                all:
                    subheader: app.ui.manage_articles
                index:
                    icon: newspaper
            templates: backend/crud
        type: sylius.resource

And add it on backend routes configuration.

.. code-block:: yaml

    # config/routes/backend.yaml

    [...]

    app_backend_article:
        resource: "backend/article.yaml"

And that’s all!

Learn More
----------

* `Configuring routes in sylius documentation`_

.. _Configuring routes in sylius documentation: https://docs.sylius.com/en/latest/components_and_bundles/bundles/SyliusGridBundle/your_first_grid.html#generating-the-crud-routing
