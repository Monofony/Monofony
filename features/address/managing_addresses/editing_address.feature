@managing_addresses
Feature: Editing a address
    In order to change information about a address
    As an Administrator
    I want to be able to edit the address

    Background:
        Given there is an address with street "666 Hell's kitchen" located at "Rennes"
        And I am logged in as an administrator

    @ui
    Scenario: Renaming an existing address
        Given I want to edit "666 Hell's kitchen" address
        When I change its title as "Star Wars"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And this address with street "Star Wars" should appear in the website
