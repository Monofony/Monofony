@viewing_addresses
Feature: Viewing a address details
    In order to see addresses detailed information
    As a Visitor
    I want to be able to view a single address

    @ui
    Scenario: Viewing a detailed page with address's title
        Given there is an address with street "666 Hell's kitchen" located at "Rennes"
        When I check this address's details
        Then I should see the address street "666 Hell's kitchen"
