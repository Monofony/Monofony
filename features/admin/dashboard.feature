@admin_dashboard
Feature: Statistics dashboard
    In order to have an overview of my database
    As an Administrator
    I want to see overall statistics on my admin dashboard

    Background:
        Given I am logged in as an administrator

    @ui
    Scenario: Seeing statistics
        Given there are 9 customers
        When I open administration dashboard
        Then I should see 9 new customers

    @ui
    Scenario: Seeing recent customers
        Given there are 4 customers
        When I open administration dashboard
        Then I should see 4 new customers in the list
