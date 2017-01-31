@ui @backend @adminUser @create
Feature: Create new admin user
  In order to manage admin users
  As an administrator
  I need to be able to create new admin users

  Background:
    Given there are admin users:
      | email             | password |
      | admin@example.com | password |
    And I am logged in on administration as user "admin@example.com" with password "password"

  Scenario: Create new admin user
    Given I am on "/admin/users/"
    And I follow "Créer"
    And I fill in the following:
      | Identifiant  | hale.ceane |
      | Nom          | Céane      |
      | Prénom       | Hale       |
      | Mot de passe | password   |
    When I press "Créer"
    Then I should see "a bien été créé"

  Scenario: Cannot create empty admin user
    Given I am on "/admin/users/"
    And I follow "Créer"
    When I press "Créer"
    Then I should see "Veuillez saisir votre mot de passe."