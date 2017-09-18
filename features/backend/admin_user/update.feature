@ui @backend @adminUser @update
Feature: Edit admin users
    In order to manage admin users
    As an administrator
    I need to be able to update admin users

    Background:
        Given there are admin users:
            | email                  | password |
            | admin@example.com      | password |
        And I am logged in on administration as user "admin@example.com" with password "password"

    Scenario: Updating an admin user
        Given I am on "/admin/users/"
        And I follow "Modifier"
        When I press "Enregistrer les modifications"
        Then I should see "a bien été mis à jour"

    Scenario: Updating password of an admin user
        Given I am on "/admin/users/"
        And I follow "Modifier"
        And  I fill in the following:
            | Mot de passe | newPassword |
        And I press "Enregistrer les modifications"
        When I am logged in on administration as user "admin@example.com" with password "newPassword"
        Then I should be on "/admin/dashboard"