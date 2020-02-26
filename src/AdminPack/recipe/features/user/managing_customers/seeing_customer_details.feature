@managing_customers
Feature: Seeing customer's details
    In order to see customer's details
    As an Administrator
    I want to be able to show specific customer's page

    Background:
        Given I am logged in as an administrator
        And there is a customer "f.baggins@shire.me" with name "Frodo Baggins" and phone number "666777888" since "2011-01-10 21:00"

    @ui
    Scenario: Seeing customer's basic information
        When I view details of the customer "f.baggins@shire.me"
        Then his name should be "Frodo Baggins"
        And he should be registered since "2011-01-10 21:00"
        And his email should be "f.baggins@shire.me"
        And his phone number should be "666777888"
