<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Provider;

final class EmailCodesProvider implements EmailCodesProviderInterface
{
    private array $emails;

    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }

    public function provideWithLabels(): array
    {
        $typesWithLabels = [];

        foreach ($this->emails as $type => $configuration) {
            $label = ucwords(str_replace('_', ' ', $type));

            $typesWithLabels[$label] = $type;
        }

        return $typesWithLabels;
    }
}
