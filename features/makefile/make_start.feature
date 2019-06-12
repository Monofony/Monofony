@makefile @cli
Feature: Use make start command
    In order to start server
    As a developer
    I want to use make start command

    Scenario: Use make start command
        Given I use default makefile commands
        Then the command make start should exist
        And it should execute "server:start"

    Scenario: Override make start command
        When I override makefile start command with "echo 'test'"
        Then the command make start should exist
        Then it should execute "echo 'test'"
        But it should not execute "server:start"
