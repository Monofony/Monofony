@makefile @cli
Feature: Using make docs build command
    In order to build application docs
    As a developer
    I want to use make docs build command

    Scenario: Using make docs build command
        Given I use default makefile commands
        Then the command make "docs-build" should exist
        And it should execute "sphinx-build"

    Scenario: Overriding make docs build command
        When I override makefile "docs-build" command with "echo 'test'" and "make docs-build-default"
        Then the command make "docs-build" should exist
        And it should execute "echo 'test'"
        And it should execute "make docs-build-default"
        But it should not execute "sphinx-build"
