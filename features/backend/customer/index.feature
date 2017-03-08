@ui @backend @customer @index
Feature: View list of customers
  In order to manage customers
  As an administrator
  I need to be able to view all the customers

  Background:
    Given there are customers:
      | email             |
      | kevin@example.com |
    Given there are admin users:
      | email             | password |
      | admin@example.com | password |
    And I am logged in on administration as user "admin@example.com" with password "password"

  Scenario: View list of customers
    When I am on "/admin/customers/"
    Then I should see "kevin@example.com"