@makefile @cli
Feature: Using make start command
    In order to start server
    As a developer
    I want to use make start command

    Scenario: Using make start command
        Given I use default makefile commands
        Then the command make start should exist
        And it should execute "server:start"

    Scenario: Overriding make start command
        When I override makefile start command with "echo 'test'" and "make start-default"
        Then the command make start should exist
        And it should execute "echo 'test'"
        And it should execute "make start-default"
        But it should not execute "server:start"
