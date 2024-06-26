<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateInterface;
use BitBag\SyliusMailTemplatePlugin\Form\Type\EmailTemplateType;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateRepositoryInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class EmailCodesProvider implements EmailCodesProviderInterface
{
    private array $emails;

    private EmailTemplateRepositoryInterface $emailTemplateRepository;

    private TranslatorInterface $dataCollectorTranslator;

    public function __construct(
        array $emails,
        EmailTemplateRepositoryInterface $emailTemplateRepository,
        TranslatorInterface $dataCollectorTranslator,
    ) {
        $this->emails = $emails;
        $this->emailTemplateRepository = $emailTemplateRepository;
        $this->dataCollectorTranslator = $dataCollectorTranslator;
    }

    public function provideWithLabels(): array
    {
        $typesWithLabels = [];

        foreach (array_keys($this->emails) as $type) {
            $label = ucwords(str_replace('_', ' ', $type));

            $typesWithLabels[$label] = $type;
        }

        return $typesWithLabels;
    }

    public function provideWithLabelsNotUsedTypes(): array
    {
        $typesWithLabels = [];

        $emailTemplateTypes = $this->getEmailTemplateTypes();
        foreach (array_keys($this->emails) as $type) {
            if (!in_array($type, array_column($emailTemplateTypes, 'type'), true)) {
                $label = ucwords(str_replace('_', ' ', $type));

                $typesWithLabels[$label] = $type;
            }
        }

        return $typesWithLabels;
    }

    public function getAvailableEmailTemplateTypes(EmailTemplateInterface $emailTemplate): array
    {
        $types = $this->provideWithLabelsNotUsedTypes();

        if (null !== $dataType = $emailTemplate->getType()) {
            $replaceDataType = str_replace('_', ' ', $dataType);

            $labelName = ucwords(strtolower($replaceDataType));

            $translatedLabelName = $this->dataCollectorTranslator->trans(
                $labelName,
                [],
                EmailTemplateType::MAIL_TEMPLATE_TYPE_DOMAIN,
            );

            $types[$translatedLabelName] = $dataType;
        }

        return $types;
    }

    private function getEmailTemplateTypes(): array
    {
        return $this->emailTemplateRepository->getAllTypes();
    }
}
