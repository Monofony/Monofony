@makefile @cli
Feature: Use make stop command
    In order to stop server
    As a developer
    I want to use make stop command

    Scenario: Use make stop command
        Given I use default makefile commands
        Then the command make stop should exist
        And it should execute "server:stop"

    Scenario: Override make start command
        When I override makefile stop command with "echo 'test'"
        Then the command make stop should exist
        Then it should execute "echo 'test'"
        But it should not execute "server:stop"
