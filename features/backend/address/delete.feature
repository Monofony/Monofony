@ui @backend @address @delete
Feature: Remove address
  In order to manage addresses
  As an admin
  I need to be able to remove addresses

  Background:
    Given there are admin users:
      | email             | password |
      | admin@example.com | password |
    And there are addresses:
      | city   |
      | Rennes |
    And I am logged in on administration as user "admin@example.com" with password "password"

  Scenario: Remove an address
    Given I am on "/admin/addresses/"
    When I press "Supprimer"
    Then I should see "a bien été supprimée"

  @javascript
  Scenario: Remove a address with modal
    Given I am on "/admin/addresses/"
    When I press "Supprimer"
    And I wait until modal is visible
    And I press confirm button
    Then I should see "a bien été supprimée"