<h1 align="center">
    <img src="https://ressources.mobizel.com/wp-content/uploads/2019/12/monofony-banner-mobizel.png" />
    <br />
    <a href="http://travis-ci.org/Monofony/Monofony" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/Monofony/Monofony/master.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/Monofony/Monofony/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/Monofony/Monofony.svg" />
    </a>    
</h1>

Installation
------------

To create your Monofony-based application, first make sure you use PHP 7.2 or higher and have [Composer](https://packagist.org/) installed.
You can check these requirements with:
```bash
$ php --version
PHP 7.2.31 (cli) (built: May 29 2020 02:00:47) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.2.0, Copyright (c) 1998-2018 Zend Technologies
    with Xdebug v2.9.1, Copyright (c) 2002-2020, by Derick Rethans
    with Zend OPcache v7.2.31, Copyright (c) 1999-2018, by Zend Technologies
$ type composer
  composer is hashed (/usr/local/bin/composer)
```

Then, create your Monofony-based project using composer.
For example, to create a project `my-new-project` run:
```bash
export SYMFONY_ENDPOINT=https://flex.symfony.com/r/github.com/symfony/recipes-contrib/871
composer create-project monofony/skeleton my-new-project
```

The end of the composer should give you some hints on what to do next.
At least, be sure to have a running database, and check the .env targets it properly.
For example, if you want a development docker container for that purpose:
```bash
$ docker run --name mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=root -d mysql:5.6.47
$ netstat -an | grep 3306
tcp46      0      0  *.3306                 *.*                    LISTEN 
$ mysql -h 127.0.0.1 -uroot -p
# check you can properly login with password root, and exit mysql

$ grep DATABASE_URL my-new-project/.env
  DATABASE_URL=mysql://root:root@127.0.0.1:3306/db_name?serverVersion=5.7 
```

Then, install and start project :
```bash
$ cd my-new-project
$ bin/console app:install
$ yarn install && yarn build (or "yarn dev" for development usage)
$ symfony server:start --no-tls
```

Your project should be available at http://127.0.0.1:8000

You should be able to login in to http://127.0.0.1:8000/admin/login with the admin you provided during the 
`bin/console app:install` command (or the default admin of the demo below if you run it with the 
no-interaction flag via `bin/console app:install -n`


Documentation
-------------
 
Documentation is available at [https://monofony.readthedocs.io/en/latest/](https://monofony.readthedocs.io/en/latest/).

Demo
----

A Demo is available.

**Admin**
- Username: admin@example.com
- Password: admin

[View Monofony admin](https://monofony.mobizel.com/admin)

**Front** 
- Username: customer@example.com
- Password: password

[View Monofony front](https://monofony.mobizel.com)

Community
---------

Stay updated by following our [Twitter](https://twitter.com/MonofonyStarter).

Contributing
------------

Would like to help us and build the best symfony-starter using Sylius? Feel free to open a pull-request!

License
-------

Monofony is completely free and released under the [MIT License](https://github.com/Monofony/SymfonyStarter/blob/master/LICENSE).

Authors
-------

Monofony was originally created by [Loïc Frémont](https://twitter.com/loic_425).
See the list of [contributors from our community](https://github.com/Monofony/SymfonyStarter/contributors).
