@ui @frontend @security @login
Feature: Login as a user
  As a visitor
  I need to be able to login as a user

  Background:
    Given there are customers:
      | email                      | password |
      | bobby.cyclette@example.com | password |

  Scenario: Login as a user
    Given I am on "/login"
    And I fill in the following:
      | E-mail       | bobby.cyclette@example.com |
      | Mot de passe | password                   |
    When I press "Connexion"
    Then I should be on the homepage