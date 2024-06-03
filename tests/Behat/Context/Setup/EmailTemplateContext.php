<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateInterface;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslationInterface;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateTranslationRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class EmailTemplateContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    private FactoryInterface $templateFactory;

    private FactoryInterface $templateTranslationFactory;

    private EmailTemplateTranslationRepositoryInterface $emailTemplateTranslationRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        FactoryInterface $templateFactory,
        FactoryInterface $templateTranslationFactory,
        EmailTemplateTranslationRepositoryInterface $emailTemplateTranslationRepository,
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->templateFactory = $templateFactory;
        $this->templateTranslationFactory = $templateTranslationFactory;
        $this->emailTemplateTranslationRepository = $emailTemplateTranslationRepository;
    }

    /**
     * @Given there is mail template with :type type and :name name and :subject subject and :content content
     */
    public function thereIsMailTemplateWithTypeAndNameAndSubjectAndContent(
        string $type,
        string $name,
        string $subject,
        string $content,
    ): void {
        $emailTemplate = $this->createEmailTemplate($type, $name, $subject, $content);

        $this->saveEmailTemplate($emailTemplate);
    }

    /**
     * @Given there is mail template with :type type and :name name and :subject subject and :content content and :locale locale
     */
    public function thereIsMailTemplateWithTypeAndNameAndSubjectAndContentAndLocale(
        string $type,
        string $name,
        string $subject,
        string $content,
        string $locale,
    ): void {
        $emailTemplate = $this->createEmailTemplate($type, $name, $subject, $content, $locale);

        $this->saveEmailTemplate($emailTemplate);
    }

    private function createEmailTemplate(
        ?string $type = null,
        ?string $name = null,
        ?string $subject = null,
        ?string $content = null,
        ?string $locale = null,
    ): EmailTemplateInterface {
        /** @var EmailTemplateTranslationInterface $emailTemplateTranslation */
        $emailTemplateTranslation = $this->templateTranslationFactory->createNew();
        $emailTemplateTranslation->setName($name ?? 'User registration template');
        $emailTemplateTranslation->setSubject($subject ?? 'User registration subject');
        $emailTemplateTranslation->setContent($content ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.');
        $emailTemplateTranslation->setLocale($locale ?? 'en_US');

        /** @var EmailTemplateInterface $emailTemplate */
        $emailTemplate = $this->templateFactory->createNew();
        $emailTemplate->setCurrentLocale($locale ?? 'en_US');
        $emailTemplate->setType($type ?? 'user_registration');
        $emailTemplate->addTranslation($emailTemplateTranslation);

        return $emailTemplate;
    }

    private function saveEmailTemplate(EmailTemplateInterface $emailTemplate): void
    {
        $this->emailTemplateTranslationRepository->add($emailTemplate);
        $this->sharedStorage->set('emailTemplate', $emailTemplate);
    }
}
