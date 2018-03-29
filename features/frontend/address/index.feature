@ui @frontend @address @index
Feature: View list of addresses
    In order to manage addresses
    As a visitor
    I need to be able to view all the addresses

    Background:
        Given there is an address located at "Rennes"
        And there is an address located at "Pacé"
        And there is an address located at "Saint-Grégoire"

    Scenario: View list of addresses
        When I am on "/adresses/"
        Then I should see "Rennes"
        And I should see "Pacé"
        And I should see "Saint-Grégoire"
