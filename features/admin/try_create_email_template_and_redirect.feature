@managing_email_templates
Feature: Try to create Email Template
  In order to redirect to list all email templates
  As an Administrator
  I want to be not able to create new email template

  Background:
    Given I am logged in as an administrator
    And the store operates on a single channel in "United States"

  @ui @javascript
  Scenario: Try create new email template
    Given I am on the email templates list
    And I have added all of custom email types
    When I click create
    Then I should be redirected to index email templates
    And I should see an error about all custom email types have defined
