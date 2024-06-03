<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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
