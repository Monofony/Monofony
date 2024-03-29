.. rst-class:: outdated

.. danger::

   This is an outdated documentation please read the new `Monofony documentation`_ instead.

.. index::
    single: Customer and AppUser

Customer and AppUser
====================

For handling customers of your system AppUser is using a combination of two entities - Customer and AppUser.
The difference between these two entities is simple: the Customer is a guest on your application and the AppUser is a user registered in the system - they have an account.

Customer
========

The Customer entity was created to collect data about non-registered guests of the system - ones that has been buying without having an account or that have somehow provided us their e-mail.

How to create a Customer programmatically?
------------------------------------------

As usually, use a factory. The only required field for the Customer entity is email, provide it before adding it to the repository.

.. code-block:: php

    /** @var CustomerInterface $customer */
    $customer = $this->container->get('sylius.factory.customer')->createNew();

    $customer->setEmail('customer@test.com');

    $this->container->get('sylius.repository.customer')->add($customer);


The Customer entity can of course hold other information besides an email, it can be for instance ``billingAddress`` and ``shippingAddress``, ``firstName``, ``lastName`` or ``birthday``.

.. note::

    The relation between the Customer and AppUser is bidirectional. Both entities hold a reference to each other.

AppUser
=======

AppUser entity is designed for customers that have registered in the system - they have an account with both e-mail and password. They can visit and modify their account.

While creating new account the existence of the provided email in the system is checked - if the email was present - it will already have a Customer therefore the existing one will be assigned to the newly created AppUser, if not - a new Customer will be created together with the AppUser.

How to create an AppUser programmatically?
------------------------------------------

Assuming that you have a Customer (either retrieved from the repository or a newly created one) - use a factory to create a new AppUser, assign the existing Customer and a password via the setPlainPassword() method.

.. code-block:: php

    /** @var ShopUserInterface $user */
    $user = $this->container->get('sylius.factory.app_user')->createNew();

    // Now let's find a Customer by their e-mail:
    /** @var CustomerInterface $customer */
    $customer = $this->container->get('sylius.repository.customer')->findOneBy(['email' => 'customer@test.com']);

    // and assign it to the ShopUser
    $user->setCustomer($customer);
    $user->setPlainPassword('pswd');

    $this->container->get('sylius.repository.app_user')->add($user);

Changing the AppUser password
-----------------------------

The already set password of an AppUser can be easily changed via the setPlainPassword() method.

.. code-block:: php

    $user->getPassword(); // returns encrypted password - 'pswd'

    $user->setPlainPassword('resu1');
    // the password will now be 'resu1' and will become encrypted while saving the user in the database

Customer related events
=======================

+---------------------------------------------+-----------------------------------------------------------------------------------------+
| Event id                                    | Description                                                                             |
+=============================================+=========================================================================================+
|``sylius.customer.post_register``            | dispatched when a new Customer is registered                                            |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.customer.pre_update``               | dispatched when a Customer is updated                                                   |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.oauth_user.post_create``            | dispatched when an OAuthUser is created                                                 |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.oauth_user.post_update``            | dispatched when an OAuthUser is updated                                                 |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.app_user.post_create``              | dispatched when a User is created                                                       |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.app_user.post_update``              | dispatched when a User is updated                                                       |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.app_user.pre_delete``               | dispatched before a User is deleted                                                     |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.user.email_verification.token``     | dispatched when a verification token is requested                                       |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.user.password_reset.request.token`` | dispatched when a reset password token is requested                                     |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.user.pre_password_change``          | dispatched before user password is changed                                              |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.user.pre_password_reset``           | dispatched before user password is reset                                                |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``sylius.user.security.implicit_login``      | dispatched when an implicit login is done                                               |
+---------------------------------------------+-----------------------------------------------------------------------------------------+
|``security.interactive_login``               | dispatched when an interactive login is done                                            |
+---------------------------------------------+-----------------------------------------------------------------------------------------+

Learn more:
-----------

.. note::

    To learn more read:
    * the `SyliusUserBundle documentation <https://docs.sylius.com/en/latest/components_and_bundles/bundles/SyliusUserBundle/index.html>`_.
    * the `SyliusCustomerBundle documentation <https://docs.sylius.com/en/latest/components_and_bundles/bundles/SyliusCustomerBundle/index.html>`_.

.. _Monofony documentation: https://docs.monofony.com
