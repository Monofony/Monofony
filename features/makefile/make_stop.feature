@makefile @cli
Feature: Using make stop command
    In order to stop server
    As a developer
    I want to use make stop command

    Scenario: Using make stop command
        Given I use default makefile commands
        Then the command make stop should exist
        And it should execute "server:stop"

    Scenario: Overriding make stop command
        When I override makefile stop command with "echo 'test'" and "make stop-default"
        Then the command make stop should exist
        And it should execute "echo 'test'"
        And it should execute "make stop-default"
        But it should not execute "server:stop"
