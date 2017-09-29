.. index::
    single: Routing

Routing
=======

SyliusResourceBundle ships with a custom route loader that can save you some time.

Generating a routing
--------------------

In order to generate routing on administration, you have to create a yaml file in ``app/config/routing/backend/`` directory and to add this file in the ````app/config/routing/backend.yml``.

In order to generate routing for API Endpoints, you have to create a yaml file in ``app/config/routing/api/`` directory and to add this file in the ````app/config/routing/api.yml``.

In order to generate routing on frontend, you have to create a yaml file in ``app/config/routing/frontend/`` directory and to add this file in the ````app/config/routing/frontend.yml``.

Routing Configuration Reference
-------------------------------

.. code-block:: yaml

    app_genre_book_remove:
        path: /{genreName}/books/{id}/remove
        methods: [DELETE]
        defaults:
            _controller: app.controller.book:deleteAction
            _sylius:
                repository:
                    method: findByGenreNameAndId
                    arguments: [$genreName, $id]
                criteria:
                    genre.name: $genreName
                    id: $id
                redirect:
                    route: app_genre_show
                    parameters: { genreName: $genreName }

Routing Generator Configuration Reference
-----------------------------------------

.. code-block:: yaml

    app_book:
        resource: |
            alias: app.book
            path: library
            identifier: code
            criteria:
                code: $code
            section: admin
            templates: :Book
            form: AppBundle/Form/Type/SimpleBookType
            redirect: create
            except: ['show']
            only: ['create', 'index']
            serialization_version: 1
        type: sylius.resource

Learn More
----------

.. note::

    To learn more, read the `Routing chapter in the ResourceBundle documentation <http://docs.sylius.org/en/latest/components_and_bundles/bundles/SyliusResourceBundle/routing.html#generating-generic-crud-routing>`_.