@ui @frontend @security @register
Feature: Register as a new user
    As a visitor
    I need to be able to register as a new user

    Scenario: Register as a new user
        Given I am on "/register"
        And I fill in the following:
            | E-mail                    | kevin@example.com |
            | Mot de passe              | password          |
            | Confirmer le mot de passe | password          |
            | Nom                       | Costner           |
            | Prénom                    | Kevin             |
            | Téléphone                 | 0605040302        |
        When I press "Créer un compte"
        Then I should be on the homepage
        And I should see "Merci pour votre inscription, vous allez recevoir un mail pour vérifier votre compte."

    Scenario: Register with an existing email
        Given there are customers:
            | email             |
            | kevin@example.com |
        And I am on "/register"
        And I fill in the following:
            | E-mail                    | kevin@example.com |
            | Mot de passe              | password          |
            | Confirmer le mot de passe | password          |
            | Nom                       | Costner           |
            | Prénom                    | Kevin             |
            | Téléphone                 | 0605040302        |
        When I press "Créer un compte"
        Then I should see "Cet e-mail est déjà utilisé."
