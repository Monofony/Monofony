![Mobizel](http://www.mobizel.com/wp-content/uploads/2013/04/logomobizel.png)

# `mzh` command helper 

## Install mzh command helper in your workstation

`mzh` is an helper to centralize and facilitate some repetitive commands used when developing an application
Once installed, this helper can be used in any Mobizel project using Vagrant.

```bash
$ cd ~/dev
$ git clone git@bitbucket.org:yannick_le_duc/rd_042_s_monofony.git
$ cd rd_042_s_monofony.git
$ ./mzh mzhinstall
```

**Note:** Normally, if everything is fine, bash completion should be available

```
$ mzh [TAB][TAB]
app           bootstrap     db            doc           listcommands  mzhversion    phpunit       reload        ssh           testdb        
behat         clean         distclean     help          mzhinstall    phpspec       reboot        resetdb       start         tests         
$ mzh p[TAB]
$ mzh php[TAB][TAB]
phpspec  phpunit
$ mzh phpu[TAB]
$ mzh phpunit
```

**Note#2:** Using mzh or direct vagrant commands, you can preserve Internet bandwidth and speed up the virtual machine creation by enabling debian package caching.
This will use local debian packages if available, and may result in a vm up in ~3m45s instead of ~8m30s (at 400 kB/s)
```
$ mkdir ~/dev/debianLocalCache
```


## Getting some help

Run `mzh` to get all available commands and some examples

```
$ mzh
Build helper to centralize Mobizel projects setup and build commands

USAGE: /usr/local/bin/mzh target1 [target2 ...]

Valid targets are:

  appinit: initialize project (migrate and load fixtures)
  appupdate: update project (composer deps, migrations etc.)
  bootstrap: clone monofony, ask some info and create a brand new project
  behat: run behat tests
  clean: stop virtual machine
  db: connect to database (command line shell)
  doc: build the documentation
  distclean: deep clean to approach fresh clone
  mzhinstall: install mzh helper binary in system path
  mzhversion: dump mzh helper version
  phpspec: run phpspec tests
  phpunit: run phpunit tests
  ssh: connect a terminal to the virtual machine (command line shell)
  start: build and start virtual machine
  reboot: power-off and reboot virtual machine, when it is stuck for example
  resetdb: drop and reset database
  reload: restart machine gracefully
  testdb: setup test database to be able to run phpunit tests
  tests: run all unit tests and save output in logs.txt

EXAMPLES:
	--- Build vagrant machine, install database and fixtures
	/usr/local/bin/mzh start app

	--- Run all tests
	/usr/local/bin/mzh tests

	--- Run behat tests
	/usr/local/bin/mzh behat

        --- Connect to the mysql database inside the virtual machine
        /usr/local/bin/mzh db
```

## Bootstrap a fresh new app

- Run `mzh bootstrap` and follow instructions
- Rename the newly created directory with the right code (instead of 000)

Example:

```bash
user@MacBookPro: ~/dev]$ mzh bootstrap
LOG_INFO: Now preparing to boostrap a new Mobizel project from monofony
Please provide the application name (eg. AppName, Wecome, ...) : MyNewApp
Text to be used instead of 'app_name'? [my_new_app] 
Text to be used instead of 'APP_NAME'? [MY_NEW_APP] 
LOG_INFO: Now ready to start boostrap with following substitutions
  'AppName' → 'MyNewApp'
  'app_name' → 'my_new_app'
  'APP_NAME' → 'MY_NEW_APP'
Proceed ? [y/N] y
LOG_INFO: Cloning monofony master into mz_000_my_new_app directory
LOG_INFO: Replacing all variants of 'AppName'
LOG_INFO: Opening security in app_dev.php
```

## Start the VM and setup the minimum stuff to start using an application

```bash
$ cd mz_000_my_new_app
$ mzh start app
```


# Manual operations (used in mzh internally)

Create a new project manually
-----------------------------

Search and replace 'app_name', 'AppName' et 'APP_NAME' with your application name


Quick Installation with Vagrant
-------------------------------

```bash
$ cd etc/vagrant
$ vagrant up
```

Quick Installation with Docker
------------------------------

```bash
$ cd etc/docker
$ docker-compose build
$ docker-compose up -d
$ docker exec -it $(docker-compose ps -q app_name_php) bash
```

Init project
------------

Install php dependencies using composer
```bash
$ composer install
```

Init project with fixtures (fake data) :
```bash
$ bin/console app:install --mode=fixture --no-interaction
```

Or init project with only one administrator :
```bash
$ bin/console app:install --no-interaction
```

If you want to work on assets, please run the following commands:

```bash
$ npm install
$ gulp
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
