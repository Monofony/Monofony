test-behat-without-javascript:
	vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="~@javascript && ~@todo && ~@cli"
.PHONY: test-behat-without-javascript

test-behat-with-javascript:
	vendor/bin/behat --strict --no-interaction -vvv -f progress --tags="@javascript && ~@todo && ~@cli"
.PHONY: test-behat-with-javascript
