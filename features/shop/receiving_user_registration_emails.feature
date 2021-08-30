@user_registration
Feature: Receiving set of welcoming emails after registration
    In order to improve the first impression of customer
    As a Visitor
    I want to receive emails with customized templates

    Background:
        Given the store operates on a single channel in "United States"
        And there is mail template with "user_registration" type and "User registration" name and "Welcome to our shop!" subject and "Enjoy our stuff!" content
        And there is mail template with "verification_token" type and "Verification token" name and "Invitation" subject and "Invitation" content

    @ui @email
    Scenario: Receiving a welcoming email after registration
        When I register with email "ghastly@bespoke.com" and password "suitsarelife"
        Then a welcoming email should have been sent to "ghastly@bespoke.com"

    @ui @email
    Scenario: Receiving account verification email after registration
        When I register with email "ghastly@bespoke.com" and password "suitsarelife"
        Then I should be notified that my account has been created and the verification email has been sent
        And 2 emails should be sent to "ghastly@bespoke.com"
        But I should not be able to log in as "ghastly@bespoke.com" with "suitsarelife" password
