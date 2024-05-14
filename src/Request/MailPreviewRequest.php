<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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
        /** @var string $name */
        $name = $request->request->get(self::NAME);
        /** @var string $subject */
        $subject = $request->request->get(self::SUBJECT);
        /** @var string $content */
        $content = $request->request->get(self::CONTENT);
        /** @var string $template */
        $template = $request->request->get(self::TEMPLATE);
        /** @var string $css */
        $css = $request->request->get(self::CSS);

        return new self($name, $subject, $content, $template, $css);
    }

    private function __construct(
        ?string $name,
        ?string $subject,
        ?string $content,
        ?string $template,
        ?string $css,
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
