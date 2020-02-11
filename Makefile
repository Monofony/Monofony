include Makefile.install
include Makefile.test
include Makefile.validation

docs-build:
	cd docs && sphinx-build -b html . build -a

install: composer-install app-install fixtures-load yarn-install yarn-build

start:
	symfony server:start --no-tls --daemon ${ARGS}

stop:
	symfony server:stop

log:
	symfony server:log

test: validate-all test-all

lint:
	vendor/bin/php-cs-fixer fix src
