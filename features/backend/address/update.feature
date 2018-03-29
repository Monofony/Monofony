@ui @backend @address @update
Feature: Edit addresses
    In order to manage addresses
    As an administrator
    I need to be able to update addresses

    Background:
        Given there are admin users:
            | email             | password |
            | admin@example.com | password |
        And there is an address located at "Rennes"
        And I am logged in on administration as user "admin@example.com" with password "password"

    Scenario: Update an address
        Given I am on "/admin/addresses/"
        And I follow "Modifier"
        When I press "Enregistrer les modifications"
        Then I should see "a bien été mise à jour"
