@customer_login
Feature: Resetting a password
    In order to login to my account when I forgot my password
    As a Visitor
    I need to be able to reset my password

    Background:
        Given the store operates on a single channel in "United States"
        And there is mail template with "reset_password_token" type and "Reset password" name and "Wanna reset password?" subject and "Here is your code:" content
        And there is a user "goodman@example.com" identified by "heisenberg"

    @ui @email
    Scenario: Resetting an account password
        When I want to reset password
        And I specify customer email as "goodman@example.com"
        And I reset it
        Then an email with reset token should be sent to "goodman@example.com"

    @ui @email
    Scenario: Changing my account password with token I received
        Given I have already received a resetting password email
        When I follow link on my email to reset my password
        And I specify my new password as "newp@ssw0rd"
        And I confirm my new password as "newp@ssw0rd"
        And I reset it
        Then I should be able to log in as "goodman@example.com" with "newp@ssw0rd" password
