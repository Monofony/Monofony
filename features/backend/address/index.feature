@ui @backend @address @index
Feature: View list of addresses
  In order to manage addresses
  As an administrator
  I need to be able to view all the addresses

  Background:
    Given there are admin users:
      | email             | password |
      | admin@example.com | password |
    And there are addresses:
      | city   |
      | Rennes |
    And I am logged in on administration as user "admin@example.com" with password "password"

  Scenario: View list of addresses
    When I am on "/admin/addresses/"
    Then I should see "Rennes"