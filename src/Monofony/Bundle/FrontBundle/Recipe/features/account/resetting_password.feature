@customer_login
Feature: Resetting a password
    In order to login to my account when I forgot my password
    As a Visitor
    I need to be able to reset my password

    Background:
        Given there is a user "goodman@example.com" identified by "heisenberg"

    @ui @email
    Scenario: Resetting an account password
        When I want to reset password
        And I specify the email as "goodman@example.com"
        And I reset it
        Then I should be notified that email with reset instruction has been sent
        And the email with reset token should be sent to "goodman@example.com"

    @ui @email
    Scenario: Changing my account password with token I received
        Given I have already received a resetting password email
        When I follow link on my email to reset my password
        And I specify my new password as "newp@ssw0rd"
        And I confirm my new password as "newp@ssw0rd"
        And I reset it
        Then I should be notified that my password has been successfully reset
