<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
