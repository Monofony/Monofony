@customer_registration
Feature: Account registration
    In order to avoid making mistakes when registering account
    As a Visitor
    I want to be prevented from creating an account without required fields

    @ui
    Scenario: Trying to register a new account with email that has been already used
        Given there is a user "goodman@gmail.com" identified by "heisenberg"
        When I want to register a new account
        And I specify the email as "goodman@gmail.com"
        And I try to register this account
        Then I should be notified that the email is already used
        And I should not be logged in

    @ui
    Scenario: Trying to register a new account without specifying password
        When I want to register a new account
        And I do not specify the password
        And I specify the email as "goodman@gmail.com"
        And I try to register this account
        Then I should be notified that the password is required
        And I should not be logged in

    @ui
    Scenario: Trying to register a new account without confirming password
        When I want to register a new account
        And I specify the email as "goodman@gmail.com"
        And I specify the password as "heisenberg"
        And I do not confirm the password
        And I try to register this account
        Then I should be notified that the password do not match
        And I should not be logged in

    @ui
    Scenario: Trying to register a new account without specifying email
        When I want to register a new account
        And I do not specify the email
        And I try to register this account
        Then I should be notified that the email is required
        And I should not be logged in
