<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Behat\Context\Ui\Admin;

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\MinkExtension\Context\RawMinkContext;
use BitBag\SyliusMailTemplatePlugin\Fixture\Factory\EmailTemplateFixtureFactory;
use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProviderInterface;
use FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException;
use function PHPUnit\Framework\assertIsInt;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertStringNotContainsString;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Tests\BitBag\SyliusMailTemplatePlugin\Behat\Page\Admin\EmailTemplate\CreatePageInterface;

final class EmailTemplateContext extends RawMinkContext
{
    private CreatePageInterface $createPage;

    private NotificationCheckerInterface $notificationChecker;

    private EmailCodesProviderInterface $emailCodesProvider;

    private EmailTemplateFixtureFactory $emailTemplateFixtureFactory;

    public function __construct(
        CreatePageInterface $createPage,
        NotificationCheckerInterface $notificationChecker,
        EmailCodesProviderInterface $emailCodesProvider,
        EmailTemplateFixtureFactory $emailTemplateFixtureFactory
    ) {
        $this->createPage = $createPage;
        $this->notificationChecker = $notificationChecker;
        $this->emailCodesProvider = $emailCodesProvider;
        $this->emailTemplateFixtureFactory = $emailTemplateFixtureFactory;
    }

    /**
     * @Given I am on the email templates create page
     *
     * @throws UnexpectedPageException
     */
    public function iAmOnTheEmailTemplatesCreatePage(): void
    {
        $this->createPage->open();
    }

    /**
     * @When /^I fill a field "([^"]*)" with value "([^"]*)"$/
     */
    public function iFillAFieldWithValue(string $field, string $value): void
    {
        $this->createPage->fillField($field, $value);
    }

    /**
     * @When /^I fill a field "([^"]*)" with value "([^"]*)" using javascript$/
     */
    public function iFillAFieldWithValueUsingJavascript(string $field, string $value): void
    {
        $this->createPage->fillInvisibleField($field, $value);
    }

    /**
     * @When /^I add it$/
     *
     * @throws ElementNotFoundException
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @Then /^I should be notified that the email template has been successfully created$/
     */
    public function iShouldBeNotifiedThatTheEmailTemplateHasBeenSuccessfullyCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Email template has been successfully created.',
            NotificationType::success()
        );
    }

    /**
     * @Given /^I click on a preview button corresponding to "([^"]*)" locale$/
     */
    public function iClickOnCorrespondingToLocale(string $locale): void
    {
        $this->createPage->preview($locale);
    }

    /**
     * @Then /^I should see a preview modal with subject "([^"]*)" and content "([^"]*)"$/
     */
    public function iShouldSeeAPreviewModalWithSubjectAndContent(string $subject, string $content): void
    {
        $this->createPage->checkHasPreviewModal($subject, $content);
    }

    /**
     * @Given I am on the email templates list
     */
    public function iAmOnTheEmailTemplatesList(): void
    {
        $this->visitPath('/admin/mail-template');
    }

    /**
     * @Given /^I have added all of custom email types$/
     */
    public function iHaveAddedAllOfCustomEmailTypes(): void
    {
        $this->addAllCustomEmailTypesInDatabase();
    }

    /**
     * @When I click create
     */
    public function iClickCreate(): void
    {
        $link = $this->assertSession()
                       ->elementExists('css', '.ui.labeled.icon.button.primary');

        $link->click();
    }

    /**
     * @Then I should be redirected to index email templates
     */
    public function iShouldBeRedirectedToIndexEmailTemplates(): void
    {
        assertStringNotContainsString('/mail-template/new', $this->getSession()->getCurrentUrl());
    }

    /**
     * @Then I should see an error about all custom email types have defined
     */
    public function iShouldSeeAnErrorAboutAllCustomEmailTypesHaveDefined(): void
    {
        $row = $this->findMessageInSyliusFlashMessage();

        assertIsInt(strpos($row->getHtml(), 'All types have defined custom template'));
    }

    /**
     * @return NodeElement
     */
    private function findMessageInSyliusFlashMessage()
    {
        $row = $this->assertSession()
                    ->elementExists('css', '.sylius-flash-message');

        assertNotNull($row, 'Not found sylius flash message');

        return $row;
    }

    private function addAllCustomEmailTypesInDatabase(): void
    {
        foreach ($this->emailCodesProvider->provideWithLabelsNotUsedTypes() as $type) {
            $options = [
                'remove_existing' => false,
                'translations' => [
                    'en_US' => [
                        'name' => "Name for {$type} type",
                        'subject' => "Subject for {$type} type",
                        'content' => "Content for {$type} type",
                    ],
                ],
            ];

            $this->emailTemplateFixtureFactory->load([$type => $options]);
        }
    }
}
