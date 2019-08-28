@makefile @cli
Feature: Using make install command
    In order to install application
    As a developer
    I want to use make install command

    Scenario: Using make install command
        Given I use default makefile commands
        Then the command make install should exist
        And it should execute "composer install"
        And it should execute "app:install"
        And it should execute "fixtures:load"
        And it should execute "yarn install"
        And it should execute "yarn encore production"

    Scenario: Overriding make install command
        When I override makefile install command with "echo 'test'" and "make install-default"
        Then the command make install should exist
        And it should execute "echo 'test'"
        And it should execute "make install-default"
        But it should not execute "composer install"
