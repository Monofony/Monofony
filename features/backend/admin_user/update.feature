@ui @backend @adminUser @update
Feature: Edit admin users
  In order to manage admin users
  As an administrator
  I need to be able to update admin users

  Background:
    Given there are admin users:
      | email                  | password |
      | admin@example.com      | password |
      | hale.ceane@example.com | password |
    And I am logged in on administration as user "admin@example.com" with password "password"

  Scenario: Update a admin user
    Given I am on "/admin/users/"
    And I follow "Modifier"
    When I press "Enregistrer les modifications"
    Then I should see "a bien été mis à jour"