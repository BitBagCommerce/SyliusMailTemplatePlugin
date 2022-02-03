@user_registration
Feature: Receiving set of welcoming emails after registration
    In order to improve the first impression of customer
    As a Visitor
    I want to receive emails with customized templates

    Background:
        Given the store operates on a single channel in "United States"

    @ui @email
    Scenario: Receiving a default welcoming email after registration
        When I register with email "ghastly@bespoke.com" and password "suitsarelife"
        Then a default welcoming email should have been sent to "ghastly@bespoke.com"

    @ui @email
    Scenario: Receiving a custom welcoming email after registration
        Given there is mail template with "user_registration" type and "User registration" name and "Welcome to our shop!" subject and "Enjoy our stuff!" content
        When I register with email "ghastly@bespoke.com" and password "suitsarelife"
        Then a welcoming email should have been sent to "ghastly@bespoke.com"

    @ui @email
    Scenario: Receiving a default account verification email after registration if no custom email with matching locale defined
        Given there is mail template with "verification_token" type and "Verification token" name and "Invitation" subject and "Verify yourself. We need you!" content and "fr_FR" locale
        When I register with email "ghastly@bespoke.com" and password "suitsarelife"
        Then I should be notified that my account has been created and the verification email has been sent
        And a default account verification email should have been sent to "ghastly@bespoke.com"
        And 2 emails should be sent to "ghastly@bespoke.com"
        But I should not be able to log in as "ghastly@bespoke.com" with "suitsarelife" password

    @ui @email
    Scenario: Receiving a custom account verification email after registration
        Given there is mail template with "verification_token" type and "Verification token" name and "Invitation" subject and "Verify yourself. We need you!" content
        When I register with email "ghastly@bespoke.com" and password "suitsarelife"
        Then I should be notified that my account has been created and the verification email has been sent
        And a custom account verification email should have been sent to "ghastly@bespoke.com"
        And 2 emails should be sent to "ghastly@bespoke.com"
        But I should not be able to log in as "ghastly@bespoke.com" with "suitsarelife" password
