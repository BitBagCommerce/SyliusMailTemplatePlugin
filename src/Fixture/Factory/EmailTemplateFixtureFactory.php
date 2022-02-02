<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Fixture\Factory;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateInterface;
use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateTranslationInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class EmailTemplateFixtureFactory implements FixtureFactoryInterface
{
    private FactoryInterface $emailTemplateFactory;

    private FactoryInterface $emailTemplateTranslationFactory;

    private EntityRepository $emailTemplateRepository;

    public function __construct(
        FactoryInterface $emailTemplateFactory,
        FactoryInterface $emailTemplateTranslationFactory,
        EntityRepository $emailTemplateRepository
    ) {
        $this->emailTemplateFactory = $emailTemplateFactory;
        $this->emailTemplateTranslationFactory = $emailTemplateTranslationFactory;
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    public function load(array $options): void
    {
        foreach ($options as $type => $fields) {
            if (
                true === $fields['remove_existing'] &&
                null !== $emailTemplate = $this->emailTemplateRepository->findOneBy(['type' => $type])
            ) {
                $this->emailTemplateRepository->remove($emailTemplate);
            }

            $styleCss = '<style>* { color: green };</style>';

            if (null === $type) {
                $type = 'contact_request';
            }

            $this->createEmailTemplate($type, $styleCss, $fields);
        }
    }

    private function createEmailTemplate(
        string $type,
        string $styleCss,
        array $emailTemplateData
    ): void
    {
        /** @var EmailTemplateInterface $emailTemplate */
        $emailTemplate = $this->emailTemplateFactory->createNew();

        $emailTemplate->setType($type);
        $emailTemplate->setStyleCss($styleCss);

        foreach ($emailTemplateData['translations'] as $localeCode => $translation) {
            /** @var EmailTemplateTranslationInterface $blockTranslation */
            $blockTranslation = $this->emailTemplateTranslationFactory->createNew();

            $blockTranslation->setLocale($localeCode);
            $blockTranslation->setName($translation['name']);
            $blockTranslation->setSubject($translation['subject']);
            $blockTranslation->setContent($translation['content']);
            $emailTemplate->addTranslation($blockTranslation);
        }

        $this->emailTemplateRepository->add($emailTemplate);
    }
}
