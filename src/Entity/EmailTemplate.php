<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Entity;

use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

class EmailTemplate implements EmailTemplateInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->initializeTranslationsCollection();
    }

    /** @var int|null */
    protected $id;

    /** @var string|null */
    protected $type;

    /** @var string|null */
    protected $styleCss;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getStyleCss(): ?string
    {
        return $this->styleCss;
    }

    public function setStyleCss(?string $styleCss): void
    {
        $this->styleCss = $styleCss;
    }

    public function getName(): ?string
    {
        return $this->getBlockTranslation()->getName();
    }

    public function setName(?string $name): void
    {
        $this->getBlockTranslation()->setName($name);
    }

    public function getSubject(): ?string
    {
        return $this->getBlockTranslation()->getSubject();
    }

    public function setSubject(?string $subject): void
    {
        $this->getBlockTranslation()->setSubject($subject);
    }

    public function getContent(): ?string
    {
        return $this->getBlockTranslation()->getContent();
    }

    public function setContent(?string $content): void
    {
        $this->getBlockTranslation()->setContent($content);
    }

    /** @return EmailTemplateTranslationInterface|TranslationInterface|null */
    protected function getBlockTranslation(): TranslationInterface
    {
        return $this->getTranslation();
    }

    protected function createTranslation(): EmailTemplateTranslation
    {
        return new EmailTemplateTranslation();
    }
}
