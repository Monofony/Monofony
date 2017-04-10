Capistrano
==========

This page give some hit about Capistrano. To go further check `the official documentation <http://capistranorb.com/>`_

Install Capistrano
------------------

We are going to use `Bundler`_ to install capistrano

.. code-block:: bash

    $ gem install bundler

Run bundler install command to install gem dependancies in the project Gemfile


.. code-block:: bash

    $ bundle install

.. _Bundler: http://bundler.io

Create your own task
--------------------

Capistrano allow you to build your own to exec during your deployment.
This exemple create a task that execute a command on deployment target server.

.. code-block:: ruby

    namespace :namespace do
        desc "task description"
        task :task_name do
          on roles(:all) do |host|
                  execute 'command executed on target server'
          end
        end
    end

Tasks hooks
-----------

Capistrano provides hooks in order to exec your task before or after a specific task.
For example if you want to run a task to set a proxy on a remote server before any git check :

.. code-block:: ruby

    before 'git:check', 'deploy:add_proxy'
