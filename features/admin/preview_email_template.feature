@managing_email_templates
Feature: Preview Email Template
  In order to check if the email templates is looking like expected
  As an Administrator
  I want to be able to preview the email template

  Background:
    Given I am logged in as an administrator
    And the store operates on a single channel in "United States"

  @ui @javascript
  Scenario: Preview a new email template
    Given I am on the email templates create page
    When I fill a field "bitbag_sylius_mail_template_plugin_template_email[styleCss]" with value "* {}" using javascript
    And I fill a field "bitbag_sylius_mail_template_plugin_template_email[type]" with value "user_registration"
    And I fill a field "bitbag_sylius_mail_template_plugin_template_email[translations][en_US][name]" with value "Custom Contact Request"
    And I fill a field "bitbag_sylius_mail_template_plugin_template_email[translations][en_US][subject]" with value "Contact Request"
    And I fill a field "bitbag_sylius_mail_template_plugin_template_email[translations][en_US][content]" with value "Customer wrote: 'Hi!'" using javascript
    And I click on a preview button corresponding to "en_US" locale
    Then I should see a preview modal with subject "Contact Request" and content "Customer wrote: 'Hi!'"
