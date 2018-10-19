@customer_account
Feature: Editing a customer profile
    In order to manage my personal information
    As a Customer
    I want to be able to edit my name and email

    Background:
        Given there is a user "francis@underwood.com" identified by "whitehouse"
        And I am logged in as "francis@underwood.com"

    @ui
    Scenario: Changing my email
        When I want to modify my profile
        And I specify the customer email as "frank@underwood.com"
        And I save my changes
        Then I should be notified that it has been successfully edited
        And my email should be "frank@underwood.com"
