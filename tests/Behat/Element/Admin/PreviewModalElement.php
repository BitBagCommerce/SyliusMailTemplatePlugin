<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Behat\Element\Admin;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Element\Element;

final class PreviewModalElement extends Element implements PreviewModalElementInterface
{
    /**
     * @throws ElementNotFoundException
     */
    public function isModalVisible(): bool
    {
        return $this->getElement('modal')->isVisible();
    }

    /**
     * @throws ElementNotFoundException
     */
    public function getSubject(): string
    {
        return $this->getElement('subject')->getText();
    }

    /**
     * @throws ElementNotFoundException
     */
    public function getContent(): string
    {
        return $this->getElement('content')->getText();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'modal' => '.mail-preview',
            'subject' => '.mail-preview > .content > .header',
            'content' => '.mail-preview > .content > .segment > p',
        ]);
    }
}
