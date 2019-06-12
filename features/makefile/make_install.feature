@makefile @cli
Feature: Use make install command
    In order to install application
    As a developer
    I want to use make install command

    Scenario: Use make install command
        Given I use default makefile commands
        Then the command make install should exist
        And it should execute "composer install"
        And it should execute "app:install"
        And it should execute "fixtures:load"
        And it should execute "yarn install"
        And it should execute "yarn build"

    Scenario: Override make install command
        When I override makefile install command with "echo 'test'"
        Then the command make install should exist
        Then it should execute "echo 'test'"
        But it should not execute "composer install"
