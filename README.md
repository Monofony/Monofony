<h1 align="center">
    Monofony
    <br />
    <a href="http://travis-ci.org/Monofony/SymfonyStarter" title="Build status" target="_blank">
        <img src="https://img.shields.io/travis/Monofony/SymfonyStarter/master.svg" />
    </a>
    <a href="https://scrutinizer-ci.com/g/Monofony/SymfonyStarter/" title="Scrutinizer" target="_blank">
        <img src="https://img.shields.io/scrutinizer/g/Monofony/SymfonyStarter.svg" />
    </a>    
</h1>

Search and replace 'app_name', 'AppName' et 'APP_NAME' with your application name


Quick Installation with Vagrant
-------------------------------

```bash
$ cd etc/vagrant
$ vagrant up
```

Init project
------------

Install php dependencies using composer
```bash
$ composer install
```

Install project :
```bash
$ bin/console app:install
$ cd assets/backend
$ yarn install && yarn run gulp
$ cd ../../
$ cd assets/frontend
$ yarn install && yarn run gulp
$ cd ../../
$ php bin/console server:start
```

[Behat](http://behat.org) scenarios
-----------------------------------

By default Behat uses `http://localhost:8080/` as your application base url. If your one is different,
you need to create `behat.yml` files that will overwrite it with your custom url:

```yaml
imports: ["behat.yml.dist"]

default:
    extensions:
        Behat\MinkExtension:
            base_url: http://my.custom.url
```

Then run selenium-server-standalone:

```bash
$ bin/selenium-server-standalone -Dwebdriver.chrome.driver=$PWD/bin/chromedriver
```

Then setup your test database:

```bash
$ php bin/console doctrine:database:create --env=test
$ php bin/console doctrine:migrations:migrate --env=test
```

You can run Behat using the following commands:

```bash
$ bin/behat
```
