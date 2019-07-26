@makefile @cli
Feature: Using make test command
    In order to test application
    As a developer
    I want to use make test command

    Scenario: Using make validate all command
        Given I use default makefile commands
        Then the command make "validate-all" should exist
        And it should execute "composer validate"
        And it should execute "doctrine:schema:validate"
        And it should execute "security:check"
        And it should execute "lint:twig"
        And it should execute "lint:yaml"

    Scenario: Using make test all command
        Given I use default makefile commands
        Then the command make "test-all" should exist
        And it should execute "phpspec run"
        And it should execute "phpstan analyse"
        And it should execute "psalm"
        And it should execute "phpunit"
        And it should execute "infection"
        And it should execute "behat"

    Scenario: Using make test command
        Given I use default makefile commands
        Then the command make test should exist
        And it should execute "composer validate"
        And it should execute "doctrine:schema:validate"
        And it should execute "security:check"
        And it should execute "lint:twig"
        And it should execute "lint:yaml"
        And it should execute "phpspec run"
        And it should execute "phpstan analyse"
        And it should execute "psalm"
        And it should execute "phpunit"
        And it should execute "infection"
        And it should execute "behat"

    Scenario: Overriding make test command
        When I override makefile test command with "echo 'test'" and "make test-default"
        Then the command make test should exist
        And it should execute "echo 'test'"
        And it should execute "make test-default"
        But it should not execute "composer validate"
