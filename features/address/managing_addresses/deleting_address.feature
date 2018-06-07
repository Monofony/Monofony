@managing_addresses
Feature: Deleting a address
    In order to get rid of deprecated addresses
    As an Administrator
    I want to be able to delete addresses

    Background:
        Given there is an address with street "666 Hell's kitchen" located at "Rennes"
        And I am logged in as an administrator

    @ui
    Scenario: Deleting an address
        Given I want to browse addresses
        When I delete address with street "666 Hell's kitchen"
        Then I should be notified that it has been successfully deleted
        And there should not be "666 Hell's kitchen" address anymore
