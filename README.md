<h1 align="center">
    <img src="https://github.com/Monofony/Monofony/raw/0.x/docs/_images/doc_logo.png" alt="Monofony Logo" />
    <br />
    <a href="https://github.com/Monofony/Monofony/actions" title="Build status" target="_blank">
        <img src="https://github.com/Monofony/Monofony/workflows/Application/badge.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/Monofony/Monofony/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/Monofony/Monofony.svg" />
    </a>    
</h1>

Installation
------------

To create your Monofony-based application, first make sure you use PHP 7.2 or higher and have [Composer](https://packagist.org/) installed.

Install Monofony using composer
```bash
export SYMFONY_ENDPOINT=https://flex.symfony.com/r/github.com/symfony/recipes-contrib/1022
composer create-project monofony/skeleton acme
```

Install project :
```bash
$ bin/console app:install
$ yarn install && yarn build (or "yarn dev" for development usage)
$ symfony server:start --no-tls
```

### Api

The Monofony skeleton is built with the admin panel only.
You can install our API package to use our default endpoints using `Api Platform`

![alt text](https://github.com/Monofony/Monofony/raw/0.x/docs/_images/api.png "Logo Title Text 1")

Uncomment `$syliusResources` binding on `config/services.yaml`

```yaml
# config/services.yaml
services:
    # ...
    _defaults:
        # ...
        bind:
            # ...
            $syliusResources: '%sylius.resources%' # for api
```

And execute the following commands:

```bash
export SYMFONY_ENDPOINT=https://flex.symfony.com/r/github.com/symfony/recipes-contrib/1022
composer require monofony/api-pack
```

### Front

To build a frontend, you can use our front-pack with default features:
* login
* register
* forgotten password
* user profile

You can install it using the following commands:

```bash
export SYMFONY_ENDPOINT=https://flex.symfony.com/r/github.com/symfony/recipes-contrib/1022
composer require monofony/front-pack
```

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
