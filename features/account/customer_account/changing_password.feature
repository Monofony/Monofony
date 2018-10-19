@customer_account
Feature: Changing a customer password
    In order to enhance the security of my account
    As a Customer
    I want to be able to change my password

    Background:
        Given there is a user "francis@underwood.com" identified by "whitehouse"
        And I am logged in as "francis@underwood.com"

    @ui
    Scenario: Changing my password
        When I want to change my password
        And I change password from "whitehouse" to "blackhouse"
        And I save my changes
        Then I should be notified that my password has been successfully changed
