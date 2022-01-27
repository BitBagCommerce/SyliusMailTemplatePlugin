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
    public const LABEL_TRANSLATION_PREFIX = 'bitbag_sylius_mail_template_plugin.ui';

    private array $emails;

    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }

    public function provideWithLabels(): array
    {
        $typesWithLabels = [];

        foreach ($this->emails as $type => $configuration) {
            $label = sprintf('%s.%s', self::LABEL_TRANSLATION_PREFIX, $type);

            $typesWithLabels[$label] = $type;
        }

        return $typesWithLabels;
    }
}
