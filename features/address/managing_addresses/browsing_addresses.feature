@managing_addresses
Feature: Browsing addresses
    In order to see all addresses in the website
    As an Administrator or a Redactor
    I want to browse addresses

    Background:
        Given there are 5 addresses located at "Rennes"
        And I am logged in as an administrator

    @ui
    Scenario: Browsing addresses
        When I want to browse addresses
        Then there should be 5 addresses in the list
