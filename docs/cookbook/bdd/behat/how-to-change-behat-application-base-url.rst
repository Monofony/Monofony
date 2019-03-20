How to change Behat application base url
----------------------------------------

By default Behat uses ``http://localhost:8080/`` as your application base url. If your one is different,
you need to create ``behat.yml`` files that will overwrite it with your custom url:

.. code-block:: yaml

    # behat.yml

    imports: ["behat.yml.dist"]

    default:
        extensions:
            Behat\MinkExtension:
                base_url: http://my.custom.url
