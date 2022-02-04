<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Response\TwigError;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Error\Error;
use Twig\Sandbox\SecurityNotAllowedFilterError;

final class SecurityNotAllowedFilterErrorResponse extends AbstractTwigErrorResponse
{
    public const MESSAGE = 'bitbag_sylius_mail_template_plugin.ui.not_allowed_twig_filter';

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    protected function getSupportedErrorClass(): string
    {
        return SecurityNotAllowedFilterError::class;
    }

    protected function getErrorMessage(Error $error): string
    {
        if (!$error instanceof SecurityNotAllowedFilterError) {
            throw new \InvalidArgumentException('Expected SecurityNotAllowedFilterError');
        }

        return sprintf($this->translator->trans(self::MESSAGE), $error->getFilterName(), $error->getTemplateLine());
    }
}
