@requesting_contact
Feature: Requesting contact
    In order to receive help from the store's support
    As a Customer
    I want to be able to send a message to the store's support

    Background:
        Given the store operates on a single channel in "United States"
        And this channel has contact email set as "contact@goodshop.com"

    @ui @email
    Scenario: Receiving a default request contact email from form
        When I want to request contact
        And I specify the email as "lucifer@morningstar.com"
        And I specify the message as "Hi! I did not receive an item!"
        And I send it
        Then I should be notified that the contact request has been submitted successfully
        And a default email with contact request should have been sent to "contact@goodshop.com" with sender "lucifer@morningstar.com"

    @ui @email
    Scenario: Receiving a default request contact email from form if no custom email with matching locale defined
        Given there is mail template with "contact_request" type and "Contact Request" name and "Contact form" subject and "{{ data.email }} wrote {{ data.message }}" content and "fr_FR" locale
        When I want to request contact
        And I specify the email as "lucifer@morningstar.com"
        And I specify the message as "Hi! I did not receive an item!"
        And I send it
        Then I should be notified that the contact request has been submitted successfully
        And a default email with contact request should have been sent to "contact@goodshop.com" with sender "lucifer@morningstar.com"

    @ui @email
    Scenario: Receiving a custom request contact email from form
        Given there is mail template with "contact_request" type and "Contact Request" name and "Contact form" subject and "{{ data.email }} wrote {{ data.message }}" content
        When I want to request contact
        And I specify the email as "lucifer@morningstar.com"
        And I specify the message as "Hi! I did not receive an item!"
        And I send it
        Then I should be notified that the contact request has been submitted successfully
        And a custom email with contact request should have been sent to "contact@goodshop.com" with sender "lucifer@morningstar.com"
