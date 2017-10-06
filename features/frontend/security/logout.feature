@ui @frontend @security @logout
Feature: Logout
    As a user
    I need to be able to logout

    Background:
        Given there are customers:
            | email                       | password |
            | francesca.lepel@example.com | password |
        And I am logged in as user "francesca.lepel@example.com" with password "password"

    Scenario: Logout
        When I am on "/logout"
        Then I should be on "/"
