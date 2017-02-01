@ui @frontend @address @index
Feature: View list of addresses
  In order to manage addresses
  As a visitor
  I need to be able to view all the addresses

  Background:
    Given there are addresses:
      | city           |
      | Rennes         |
      | Pacé           |
      | Saint-Grégoire |

  Scenario: View list of addresses
    When I am on "/adresses/"
    Then I should see "Rennes"