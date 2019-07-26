@makefile @cli
Feature: Using make lint command
    In order to fix coding standards
    As a developer
    I want to use make lint command

    Scenario: Using make lint command
        Given I use default makefile commands
        Then the command make lint should exist
        And it should execute "php-cs-fixer"

    Scenario: Overriding make start command
        When I override makefile lint command with "echo 'test'" and "make lint-default"
        Then the command make lint should exist
        And it should execute "echo 'test'"
        And it should execute "make lint-default"
        But it should not execute "php-cs-fixer"
