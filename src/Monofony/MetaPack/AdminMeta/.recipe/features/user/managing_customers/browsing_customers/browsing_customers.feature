@managing_customers
Feature: Browsing customers
    In order to see all customers in the admin panel
    As an Administrator
    I want to browse customers

    Background:
        Given there is a customer "f.baggins@example.com"
        And there is also a customer "mr.banana@example.com"
        And there is also a customer "l.skywalker@example.com"
        And I am logged in as an administrator

    @ui
    Scenario: Browsing customers in the admin panel
        When I want to see all customers in the admin panel
        Then I should see 3 customers in the list
        And I should see the customer "mr.banana@example.com" in the list
