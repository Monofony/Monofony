@managing_addresses
Feature: Adding a new address
    In order to extend addresses database
    As an Administrator
    I want to add a new address to the website

    @ui
    Scenario: Adding a new address
        Given I am logged in as an administrator
        And I want to create a new address
        And I specify its street as "666 Hell's kitchen"
        And I specify its postcode as "35000"
        And I specify its city as "Rennes"
        When I add it
        Then I should be notified that it has been successfully created
        And this address with street "666 Hell's kitchen" should appear in the website
