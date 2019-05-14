.. index::
    single: AdminUser

AdminUser
=========

The **AdminUser** entity extends the **User** entity. It is created to enable administrator accounts that have access to the administration panel.

How to create an AdminUser programmatically?
--------------------------------------------

The **AdminUser** is created just like every other entity, it has its own factory. By default it will have an administration **role** assigned.

.. code-block:: php

   /** @var AdminUserInterface $admin */
   $admin = $this->container->get('sylius.factory.admin_user')->createNew();

   $admin->setEmail('administrator@test.com');
   $admin->setPlainPassword('pswd');

   $this->container->get('sylius.repository.admin_user')->add($admin);

Administration Security
-----------------------

In **Monofony** by default you have got the administration panel routes (``/admin/*``) secured by a firewall - its configuration
can be found in the ``config/packages/security.yaml`` file.

Only the logged in **AdminUsers** are eligible to enter these routes.

Learn more
----------

.. note::

    To learn more, read the `UserBundle documentation <http://docs.sylius.org/en/latest/components_and_bundles/bundles/SyliusUserBundle/index.html>`_.
