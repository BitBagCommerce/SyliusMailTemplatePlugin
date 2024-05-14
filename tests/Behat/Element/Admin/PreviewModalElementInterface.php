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
