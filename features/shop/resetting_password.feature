@customer_login
Feature: Resetting a password
    In order to login to my account when I forgot my password
    As a Visitor
    I need to be able to reset my password

    Background:
        Given the store operates on a single channel in "United States"
        And there is a user "goodman@example.com" identified by "heisenberg"

    @ui @email
    Scenario: Receiving a default reset password email
        When I want to reset password
        And I specify customer email as "goodman@example.com"
        And I reset it
        Then a default email with reset token should be sent to "goodman@example.com"

    @ui @email
    Scenario: Receiving a custom reset password email
        Given there is mail template with "reset_password_token" type and "Reset password" name and "Wanna reset password?" subject and "Wanna reset password? Here is your code:" content
        When I want to reset password
        And I specify customer email as "goodman@example.com"
        And I reset it
        Then a custom email with reset token should be sent to "goodman@example.com"
