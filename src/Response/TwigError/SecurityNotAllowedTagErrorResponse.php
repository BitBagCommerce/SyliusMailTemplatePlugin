<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Response\TwigError;

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Error\Error;
use Twig\Sandbox\SecurityNotAllowedTagError;

final class SecurityNotAllowedTagErrorResponse extends AbstractTwigErrorResponse
{
    public const MESSAGE = 'bitbag_sylius_mail_template_plugin.ui.not_allowed_twig_tag';

    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    protected function getSupportedErrorClass(): string
    {
        return SecurityNotAllowedTagError::class;
    }

    protected function getErrorMessage(Error $error): string
    {
        if (!$error instanceof SecurityNotAllowedTagError) {
            throw new \InvalidArgumentException('Expected SecurityNotAllowedTagError.');
        }

        return sprintf($this->translator->trans(self::MESSAGE), $error->getTagName(), $error->getTemplateLine());
    }
}
