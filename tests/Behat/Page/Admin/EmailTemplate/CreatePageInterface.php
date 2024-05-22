<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Behat\Page\Admin\EmailTemplate;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as BaseCreatePageInterface;

interface CreatePageInterface extends BaseCreatePageInterface
{
    public function fillField(string $field, string $value): void;

    public function fillInvisibleField(string $field, string $value): void;

    public function preview(string $locale): void;

    public function checkHasPreviewModal(string $subject, string $content): void;
}
