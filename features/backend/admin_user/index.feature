@ui @backend @adminUser @index
Feature: View list of admin users
  In order to manage admin users
  As an administrator
  I need to be able to view all the admin users

  Background:
    Given there are admin users:
      | email                  | password |
      | admin@example.com      | password |
      | hale.ceane@example.com | password |
    And I am logged in on administration as user "admin@example.com" with password "password"

  Scenario: View list of admin users
    When I am on "/admin/users/"
    Then I should see "hale.ceane@example.com"