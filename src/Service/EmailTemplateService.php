<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Service;

use BitBag\SyliusMailTemplatePlugin\Entity\EmailTemplateInterface;
use BitBag\SyliusMailTemplatePlugin\Form\Type\EmailTemplateType;
use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProviderInterface;
use Symfony\Component\Translation\DataCollectorTranslator;

final class EmailTemplateService implements EmailTemplateServiceInterface
{
    private EmailCodesProviderInterface $emailCodesProvider;

    private DataCollectorTranslator $dataCollectorTranslator;

    public function __construct(
        EmailCodesProviderInterface $emailCodesProvider,
        DataCollectorTranslator $dataCollectorTranslator
    ) {
        $this->emailCodesProvider = $emailCodesProvider;
        $this->dataCollectorTranslator = $dataCollectorTranslator;
    }

    public function getAvailableEmailTemplateTypes(EmailTemplateInterface $emailTemplate): array
    {
        $types = $this->emailCodesProvider->provideWithLabelsNotUsedTypes();
        if (null !== $emailTemplate->getId() && null !== $dataType = $emailTemplate->getType()) {
            $replaceDataType = str_replace('_', ' ', $dataType);
            $labelName = ucwords(strtolower($replaceDataType));

            $types[$this->dataCollectorTranslator->trans($labelName, [], EmailTemplateType::MAIL_TEMPLATE_TYPE_DOMAIN)] = $dataType;
        }

        return $types;
    }
}
