<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Repository\DataFixtures\Provider;

use BitBag\SyliusMailTemplatePlugin\Provider\EmailCodesProviderInterface;

class EmailTemplateTypeProvider
{
    private EmailCodesProviderInterface $emailCodesProvider;

    public function __construct(EmailCodesProviderInterface $emailCodesProvider)
    {
        $this->emailCodesProvider = $emailCodesProvider;
    }

    public function nameType()
    {
        $types = $this->emailCodesProvider->provideWithLabelsNotUsedTypes();
        $typeIndex = array_rand($types);

        return $types[$typeIndex];
    }
}
