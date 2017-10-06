@ui @backend @address @create
Feature: Create new address
    In order to manage addresses
    As an administrator
    I need to be able to create new addresses

    Background:
        Given there are admin users:
            | email             | password |
            | admin@example.com | password |
        And I am logged in on administration as user "admin@example.com" with password "password"

    Scenario: Create new address
        Given I am on "/admin/addresses/"
        And I follow "Créer"
        And I fill in the following:
            | Adresse     | 2 rue de la Mabilais |
            | Code postal | 35000                |
            | Ville       | Rennes               |
        When I press "Créer"
        Then I should see "a bien été créée"

    Scenario: Cannot create empty address
        Given I am on "/admin/addresses/"
        And I follow "Créer"
        When I press "Créer"
        Then I should see "Cette valeur ne doit pas être vide."
