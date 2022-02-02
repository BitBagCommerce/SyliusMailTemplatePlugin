<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Request;

use Symfony\Component\HttpFoundation\Request;

final class MailPreviewRequest implements RequestDtoInterface
{
    public const NAME = 'name';

    public const SUBJECT = 'subject';

    public const CONTENT = 'content';

    public const TEMPLATE = 'template';

    public const CSS = 'styleCss';

    private ?string $name;

    private ?string $subject;

    private ?string $content;

    private ?string $template;

    private ?string $css;

    public static function createFromRequest(Request $request): self
    {
        $name = $request->request->get(self::NAME);
        $subject = $request->request->get(self::SUBJECT);
        $content = $request->request->get(self::CONTENT);
        $template = $request->request->get(self::TEMPLATE);
        $css = $request->request->get(self::CSS);

        return new self($name, $subject, $content, $template, $css);
    }

    private function __construct(
        ?string $name,
        ?string $subject,
        ?string $content,
        ?string $template,
        ?string $css
    ) {
        $this->name = $name;
        $this->subject = $subject;
        $this->content = $content;
        $this->template = $template;
        $this->css = $css;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function getCss(): ?string
    {
        return $this->css;
    }

    public function toArray(): array
    {
        return [
            self::NAME => $this->getName(),
            self::SUBJECT => $this->getSubject(),
            self::CONTENT => $this->getContent(),
            self::TEMPLATE => $this->getTemplate(),
            self::CSS => $this->getCss(),
        ];
    }
}
