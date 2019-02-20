@installer @cli
Feature: Install feature
    In order to install AppName via CLI
    As a Developer
    I want to run an installation command

    Scenario: Registering administrator account
        Given I provide full administrator data
        When I run Install setup command
        Then I should see output "Administrator account successfully registered."

    Scenario: Trying to register administrator account without email
        Given I do not provide an email
        When I run Install setup command
        Then I should see output "E-mail: This value should not be blank."

    Scenario: Trying to register administrator account with an incorrect email
        Given I do not provide a correct email
        When I run Install setup command
        Then I should see output "E-mail: This value is not a valid email address."

