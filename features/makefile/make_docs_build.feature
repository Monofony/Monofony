@makefile @cli
Feature: Use make docs build command
    In order to build application docs
    As a developer
    I want to use make docs build command

    Scenario: Use make docs build command
        Given I use default makefile commands
        Then the command make "docs-build" should exist
        And it should execute "sphinx-build"

    Scenario: Override make docs build command
        When I override makefile "docs-build" command with "echo 'test'"
        Then the command make "docs-build" should exist
        Then it should execute "echo 'test'"
        But it should not execute "sphinx-build"
