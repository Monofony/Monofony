@ui @backend @customer @update
Feature: Edit customers
    In order to manage customers
    As an administrator
    I need to be able to update customers

    Background:
        Given there are customers:
            | email             |
            | kevin@example.com |
        And there are following admin users:
            | email             | password |
            | admin@example.com | password |
        And I am logged in on administration as user "admin@example.com" with password "password"

    Scenario: Update a customer
        Given I am on "/admin/customers/"
        And I follow "Modifier"
        When I press "Enregistrer les modifications"
        Then I should see "a bien été mis à jour"
