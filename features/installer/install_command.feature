@installer @cli
Feature: Install feature
  In order to use AppName
  As a Developer
  I want to run a command that install AppName

  Scenario: Running install data command
    Given I run Install data command
    Then I should see output "Loading AppName data"
    And the command should finish successfully

  Scenario: Running install setup command
    Given I run Install setup command
    Then the command should finish successfully