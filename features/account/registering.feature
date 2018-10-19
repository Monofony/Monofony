@customer_registration
Feature: Account registration
    In order to make future contributions
    As a Visitor
    I need to be able to create an account in the website

    @ui
    Scenario: Registering a new account
        When I want to register a new account
        And I specify the email as "goodman@gmail.com"
        And I specify the password as "heisenberg"
        And I confirm this password
        And I register this account
        Then I should be notified that new account has been successfully created
        But I should not be logged in

    @ui @email @todo
    Scenario: Receiving a welcoming email after registration
        When I register with email "ghastly@bespoke.com" and password "suitsarelife"
        Then I should be notified that new account has been successfully created
        And a welcoming email should have been sent to "ghastly@bespoke.com"
