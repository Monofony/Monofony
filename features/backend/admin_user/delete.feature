@ui @backend @adminUser @delete
Feature: Remove admin user
  In order to manage admin users
  As an admin
  I need to be able to remove admin users

  Background:
    Given there are admin users:
      | email                  | password |
      | admin@example.com      | password |
      | hale.ceane@example.com | password |
    And I am logged in on administration as user "admin@example.com" with password "password"

  Scenario: Remove a admin user
    Given I am on "/admin/users/"
    When I press "Supprimer"
    Then I should see "a bien été supprimé"

  @javascript
  Scenario: Remove a admin user with modal
    Given I am on "/admin/users/"
    When I press "Supprimer"
    And I wait until modal is visible
    And I press confirm button
    Then I should see "a bien été supprimé"