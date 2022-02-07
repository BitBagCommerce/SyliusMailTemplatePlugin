<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\UnexpectedPageException;
use Sylius\Behat\NotificationType;
use Sylius\Behat\Service\NotificationCheckerInterface;
use Tests\BitBag\SyliusMailTemplatePlugin\Behat\Page\Admin\EmailTemplate\CreatePageInterface;

final class EmailTemplateContext implements Context
{
    private CreatePageInterface $createPage;

    private NotificationCheckerInterface $notificationChecker;

    public function __construct(CreatePageInterface $createPage, NotificationCheckerInterface $notificationChecker)
    {
        $this->createPage = $createPage;
        $this->notificationChecker = $notificationChecker;
    }

    /**
     * @Given I am on the email templates create page
     *
     * @throws UnexpectedPageException
     */
    public function iAmOnTheEmailTemplatesCreatePage()
    {
        $this->createPage->open();
    }


    /**
     * @Then /^I fill a field "([^"]*)" with value "([^"]*)"$/
     */
    public function iFillAFieldWithValue(string $field, string $value): void
    {
        $this->createPage->fillField($field, $value);
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
}
