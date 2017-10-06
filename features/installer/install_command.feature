@installer @cli
Feature: Install feature
    In order to use AppName
    As a Developer
    I want to run a command that install AppName

    @database
    Scenario: Running install database command
        When I run Install database command
        Then the command should finish successfully

    @setup
    Scenario: Running install setup command
        Given I provide full administrator data
        When I run Install setup command
        Then the command should finish successfully

    @setup
    Scenario: Trying to register administrator account without email
        Given I do not provide an email
        When I run Install setup command
        Then I should see output "E-mail: Cette valeur ne doit pas être vide."

    @setup
    Scenario: Trying to register administrator account with an incorrect email
        Given I do not provide a correct email
        When I run Install setup command
        Then I should see output "E-mail: Cette valeur n'est pas une adresse email valide."

