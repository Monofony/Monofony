@customer_login
Feature: Signing in to the website
    In order to view my account
    As a Visitor
    I want to be able to log in to the website

    Background:
        Given there is a user "ted@example.com" identified by "bear"

    @ui
    Scenario: Sign in with email and password
        When I want to log in
        And I specify the username as "ted@example.com"
        And I specify the password as "bear"
        And I log in
        Then I should be logged in
