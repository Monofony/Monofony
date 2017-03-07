@ui @frontend @account @update_password
Feature: Update password
  In order to manage my account
  As a user
  I need to be able to change my password

  Background:
    Given there are customers:
      | email             | password |
      | kevin@example.com | password |
    And I am logged in as user "kevin@example.com" with password "password"

  Scenario: Update my password
    Given I am on "/mon-compte/accueil"
    And I follow "Changer votre mot de passe"
    And I fill in the following:
      | Mot de passe actuel  | password        |
      | Nouveau mot de passe | my_new_password |
      | Confirmation         | my_new_password |
    When I press "Enregistrer les modifications"
    Then I should see "Votre mot de passe a été mis à jour avec succès !"