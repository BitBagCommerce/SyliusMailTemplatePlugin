<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Validator;

use Symfony\Component\Validator\Constraint;

class IsRenderableMailContent extends Constraint
{
    public const INVALID_CONTENT_MESSAGE = 'bitbag_sylius_mail_template_plugin.is_renderable_mail_content.invalid_content';

    public function validatedBy(): string
    {
        return 'bitbag_sylius_mail_template_plugin_validator_is_renderable_mail_content';
    }

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
