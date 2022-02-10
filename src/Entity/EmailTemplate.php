<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Entity;

use Sylius\Component\Resource\Model\TranslatableTrait;

class EmailTemplate implements EmailTemplateInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
    }

    public function __construct()
    {
        $this->initializeTranslationsCollection();
    }

    protected ?int $id = null;

    protected ?string $type;

    protected ?string $styleCss;

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

    protected function getBlockTranslation(): EmailTemplateTranslationInterface
    {
        /** @var EmailTemplateTranslationInterface $translation */
        $translation = $this->getTranslation();

        return $translation;
    }

    protected function createTranslation(): EmailTemplateTranslation
    {
        return new EmailTemplateTranslation();
    }
}
