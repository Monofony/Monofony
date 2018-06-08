@viewing_addresses
Feature: Viewing addresses
    In order to see addresses
    As a Visitor
    I want to be able to browse addresses

    @ui
    Scenario: Viewing addresses
        Given there is an address with street "666 Hell's kitchen" located at "Rennes"
        And there is an address with street "42 Universal response street" located at "London"
        When I want to browse addresses
        Then I should see the address "666 Hell's kitchen"
        And I should see the address "42 Universal response street"
