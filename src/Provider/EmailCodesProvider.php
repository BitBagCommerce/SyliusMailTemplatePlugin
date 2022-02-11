<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Repository\EmailTemplateRepositoryInterface;

final class EmailCodesProvider implements EmailCodesProviderInterface
{
    private array $emails;

    private EmailTemplateRepositoryInterface $emailTemplateRepository;

    public function __construct(array $emails, EmailTemplateRepositoryInterface $emailTemplateRepository)
    {
        $this->emails = $emails;
        $this->emailTemplateRepository = $emailTemplateRepository;
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

    private function getEmailTemplateTypes(): array
    {
        return $this->emailTemplateRepository->getAllTypes();
    }
}
