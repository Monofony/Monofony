@managing_customers
Feature: Sorting customers by their emails
    In order to faster find customers
    As an Administrator
    I want to be able to sort customers by email

    Background:
        Given there is a customer "f.baggins@example.com"
        And there is also a customer "mr.banana@example.com"
        And there is also a customer "l.skywalker@example.com"
        And I am logged in as an administrator

    @ui
    Scenario: Customers can be sorted by their emails
        Given I am browsing customers
        When I start sorting customers by email
        Then I should see 3 customers in the list
        And the first customer in the list should have email "mr.banana@example.com"
        And the last customer in the list should have email "f.baggins@example.com"
