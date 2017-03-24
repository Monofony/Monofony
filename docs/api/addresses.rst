Addresses API
=============

People API endpoint is ``/api/addresses``.

Index of all addresses
----------------------

To browse all addresses available you can call the following GET request:

.. code-block:: text

    GET /api/addresses/

Parameters
~~~~~~~~~~

page
    Number of the page, by default = 1
limit
    Number of items to display per page

Response
~~~~~~~~

Response will contain a paginated list of people.

.. code-block:: text

    STATUS: 200 OK

.. code-block:: json

    {
      "page": 1,
      "limit": 10,
      "pages": 1,
      "total": 2,
      "_links": {
        "self": {
          "href": "/api/addresses/?page=1&limit=10"
        },
        "first": {
          "href": "/api/addresses/?page=1&limit=10"
        },
        "last": {
          "href": "/api/addresses/?page=1&limit=10"
        }
      },
      "_embedded": {
        "items": [
          {
            "street": "2 rue de la Mabilais",
            "postcode": "35000",
            "city": "Rennes",
            "id": 1
          },
          {
            "street": "4 rue d'Isly",
            "postcode": "35000",
            "city": "Rennes",
            "id": 2
          }
        ]
      }
    }

Getting a single address
------------------------

You can view a single address by executing the following request:

.. code-block:: text

    GET /api/address/1

Response
~~~~~~~~

.. code-block:: text

    STATUS: 200 OK

.. code-block:: json

    {
        "street": "2 rue de la Mabilais",
        "postcode": "35000",
        "city": "Rennes",
        "id": 1
    }
