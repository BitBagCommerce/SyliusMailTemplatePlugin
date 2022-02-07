@managing_email_templates
Feature: Creating Email Template
  In order to send custom email messages
  As an Administrator
  I want to be able to create new email templates

  Background:
    Given I am logged in as an administrator
    And the store operates on a single channel in "United States"

  @ui
  Scenario: Creating a new email template
    Given I am on the email templates create page
    When I fill a field "bitbag_sylius_mail_template_plugin_template_email[styleCss]" with value "* {}"
    And I fill a field "bitbag_sylius_mail_template_plugin_template_email[type]" with value "user_registration"
    And I fill a field "bitbag_sylius_mail_template_plugin_template_email[translations][en_US][name]" with value "Custom Contact Request"
    And I fill a field "bitbag_sylius_mail_template_plugin_template_email[translations][en_US][subject]" with value "Contact Request"
    And I fill a field "bitbag_sylius_mail_template_plugin_template_email[translations][en_US][content]" with value "Customer wrote: 'Hi!'"
    And I add it
    Then I should be notified that the email template has been successfully created
