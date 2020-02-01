How to create your own statistics
=================================

The mechanism behind the displaying of statistics relies on tagged services which are supported since Symfony 4.3

Create your own statistic
-------------------------
Add a new class to ``/src/Dashboard/Statistic`` and make sure it implement the ``App\Dashboard\Statistics\StatisticInterface``.
This way it will be automatically tagged with ``app.dashboard_statistic`` which is used to fetch all existing statistics.

It also enforces you to implement a function called ``generate()`` which need to return a string.

.. note::
    The response of the generate function will be displayed as is in the dashboard.
    Which means you can return anything, as long as it is a string.
    Eg. in the CustomerStatistic it is an HTML block which shows you the amount of registered customers.

Order your statistics
---------------------

Since Symfony 4.4 it is possible to sort your services with a static function called ``getDefaultPriority``.
Here you need to return an integer to set the weight of the service. Statistics with a higher priority will be displayed first.
This is why we chose to work with negative values. (-1 for the first element, -2 for the second,...).
But feel free to use your own sequence when adding more statistics.

.. code-block:: php

    public static function getDefaultPriority(): int
    {
        return -1;
    }


.. warning::
    If you change the priority it is necessary to clear your cache. Otherwise you won't see the difference.

Add custom logic to your statistic
----------------------------------

Because all statistics are services it's perfectly possible to do anything with them as long as the generate function
returns a string. So you can inject any service you want trough Dependency Injection to build your statistic.