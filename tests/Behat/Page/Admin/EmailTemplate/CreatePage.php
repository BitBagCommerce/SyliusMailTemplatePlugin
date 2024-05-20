<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Behat\Page\Admin\EmailTemplate;

use ArrayAccess;
use Behat\Gherkin\Exception\NodeException;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\Mink\Session;
use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;
use Symfony\Component\Routing\RouterInterface;
use Tests\BitBag\SyliusMailTemplatePlugin\Behat\Element\Admin\PreviewModalElementInterface;
use Webmozart\Assert\Assert;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    private PreviewModalElementInterface $previewModal;

    /**
     * @param array|ArrayAccess $minkParameters
     */
    public function __construct(
        Session $session,
        $minkParameters,
        RouterInterface $router,
        string $routeName,
        PreviewModalElementInterface $previewModal,
    ) {
        parent::__construct($session, $minkParameters, $router, $routeName);

        $this->previewModal = $previewModal;
    }

    /**
     * @throws ElementNotFoundException
     */
    public function fillField(string $field, string $value): void
    {
        $this->getDocument()->fillField($field, $value);
    }

    public function fillInvisibleField(string $field, string $value): void
    {
        $this->getDriver()->executeScript(
            sprintf('document.querySelector("[name=\'%s\']").value = "%s";', $field, $value),
        );
    }

    public function preview(string $locale): void
    {
        /** @var ?NodeElement $node */
        $node = $this->getDocument()->find('css', sprintf('[data-locale="%s"] .bitbag_preview_mail_template', $locale));

        if (null === $node) {
            throw new NodeException();
        }

        $node->click();
    }

    /**
     * @throws ElementNotFoundException
     * @throws DriverException
     * @throws UnsupportedDriverActionException
     */
    public function checkHasPreviewModal(string $subject, string $content): void
    {
        $this->getDriver()->wait(1000, 'document.querySelector(".mail-preview").offsetParent !== null');
        Assert::true($this->previewModal->isModalVisible());
        /** @phpstan-ignore-next-line  */
        Assert::contains($this->previewModal->getSubject(), $subject);
        /** @phpstan-ignore-next-line  */
        Assert::contains($this->previewModal->getContent(), $content);
    }
}
