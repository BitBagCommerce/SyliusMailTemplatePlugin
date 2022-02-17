<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateInterface;
use BitBag\SyliusMailTemplatePlugin\Form\Type\EmailTemplateType;
use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateRepositoryInterface;
use Symfony\Component\Translation\DataCollectorTranslator;

final class EmailCodesProvider implements EmailCodesProviderInterface
{
    private array $emails;

    private EmailTemplateRepositoryInterface $emailTemplateRepository;

    private DataCollectorTranslator $dataCollectorTranslator;

    public function __construct(
        array $emails,
        EmailTemplateRepositoryInterface $emailTemplateRepository,
        DataCollectorTranslator $dataCollectorTranslator
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
        if (null !== $emailTemplate->getId() && null !== $dataType = $emailTemplate->getType()) {
            $replaceDataType = str_replace('_', ' ', $dataType);
            $labelName = ucwords(strtolower($replaceDataType));

            $types[$this->dataCollectorTranslator->trans($labelName, [], EmailTemplateType::MAIL_TEMPLATE_TYPE_DOMAIN)] = $dataType;
        }

        return $types;
    }

    private function getEmailTemplateTypes(): array
    {
        return $this->emailTemplateRepository->getAllTypes();
    }
}
