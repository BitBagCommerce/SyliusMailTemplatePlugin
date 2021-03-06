<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Behat\Element\Admin;

use Behat\Mink\Exception\ElementNotFoundException;

interface PreviewModalElementInterface
{
    /**
     * @throws ElementNotFoundException
     */
    public function isModalVisible(): bool;

    /**
     * @throws ElementNotFoundException
     */
    public function getSubject(): string;

    /**
     * @throws ElementNotFoundException
     */
    public function getContent(): string;
}
