@managing_addresses
Feature: Articles validation
    In order to avoid making mistakes when managing addresses
    As an Administrator
    I want to be prevented from adding it without specifying required fields

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Trying to add a new address without title
        Given I want to create a new address
        When I do not specify its street
        And I try to add it
        Then I should be notified that the street is required
        And this address should not be added
