Deployment
==========

Authorized keys API
-------------------

Adding ssh authorized keys for server on your local computer

.. code-block:: bash

    $ cat ~/.ssh/id_rsa.pub | ssh jedisjeux@92.243.10.152 "cat - >> ~/.ssh/authorized_keys"

and enter the correct password for username "jedisjeux" on server


Install dependencies
--------------------

.. code-block:: bash

    $ bundle install

Deploy the staging environment
------------------------------

.. code-block:: bash

    $ bundle exec "cap staging deploy"

Deploy the production environment
---------------------------------

.. code-block:: bash

    $ bundle exec "cap production deploy"