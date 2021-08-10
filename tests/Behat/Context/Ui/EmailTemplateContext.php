<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusMailTemplatePlugin\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Test\Services\EmailCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

final class EmailTemplateContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    private EmailCheckerInterface $emailChecker;

    private TranslatorInterface $translator;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        EmailCheckerInterface $emailChecker,
        TranslatorInterface $translator
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->emailChecker = $emailChecker;
        $this->translator = $translator;
    }

    /**
     * @Then it should be sent to :recipient
     * @Then the email with contact request should be sent to :recipient
     */
    public function anEmailShouldBeSentTo(string $recipient): void
    {
        Assert::true($this->emailChecker->hasRecipient($recipient));
    }

    /**
     * @Then an email with reset token should be sent to :recipient
     * @Then an email with reset token should be sent to :recipient in :localeCode locale
     */
    public function anEmailWithResetTokenShouldBeSentTo(string $recipient, string $localeCode = 'en_US'): void
    {
        $this->assertEmailContainsMessageTo(
            'Wanna reset password?',
            $recipient
        );
    }

    /**
     * @Then an email with the :method shipment's confirmation for the :orderNumber order should be sent to :email
     */
    public function anEmailWithShipmentsConfirmationForTheOrderShouldBeSentTo(string $method, string $orderNumber, string $recipient): void
    {
        Assert::true($this->emailChecker->hasMessageTo(
            sprintf(
                'Your order with number %s has been sent using %s.',
                $orderNumber,
                $method
            ),
            $recipient
        ));
    }

    /**
     * @Then :count email(s) should be sent to :recipient
     */
    public function numberOfEmailsShouldBeSentTo(int $count, string $recipient): void
    {
        Assert::same($this->emailChecker->countMessagesTo($recipient), $count);
    }


    /**
     * @Then a welcoming email should have been sent to :recipient
     * @Then a welcoming email should have been sent to :recipient in :localeCode locale
     */
    public function aWelcomingEmailShouldHaveBeenSentTo(string $recipient, string $localeCode = 'en_US'): void
    {
        $this->assertEmailContainsMessageTo(
            'Enjoy our stuff!',
            $recipient
        );
    }

    /**
     * @Then an email with the confirmation of the order :order should be sent to :email
     * @Then an email with the confirmation of the order :order should be sent to :email in :localeCode locale
     */
    public function anEmailWithTheConfirmationOfTheOrderShouldBeSentTo(
        OrderInterface $order,
        string $recipient,
        string $localeCode = 'en_US'
    ): void {
        $this->assertEmailContainsMessageTo(
            sprintf(
                '%s %s %s',
                'Congratulations, you have bought new gun',
                'Pif paf',
                $order->getNumber()
            ),
            $recipient
        );
    }

    /**
     * @Then /^an email with the summary of (order placed by "[^"]+") should be sent to him$/
     * @Then /^an email with the summary of (order placed by "[^"]+") should be sent to him in ("([^"]+)" locale)$/
     */
    public function anEmailWithSummaryOfOrderPlacedByShouldBeSentTo(OrderInterface $order, string $localeCode = 'en_US'): void
    {
        $this->anEmailWithTheConfirmationOfTheOrderShouldBeSentTo($order, $order->getCustomer()->getEmailCanonical(), $localeCode);
    }

    /**
     * @Then /^an email with shipment's details of (this order) should be sent to "([^"]+)"$/
     * @Then /^an email with shipment's details of (this order) should be sent to "([^"]+)" in ("([^"]+)" locale)$/
     * @Then an email with the shipment's confirmation of the order :order should be sent to :recipient
     * @Then an email with the shipment's confirmation of the order :order should be sent to :recipient in :localeCode locale
     */
    public function anEmailWithShipmentDetailsOfOrderShouldBeSentTo(
        OrderInterface $order,
        string $recipient,
        string $localeCode = 'en_US'
    ): void {
        $this->assertEmailContainsMessageTo(
            sprintf(
                '%s %s %s %s',
                'Your products are waiting for you!',
                'Enjoy your new stuff!',
                $order->getNumber(),
                $this->getShippingMethodName($order)
            ),
            $recipient
        );

        if ($this->sharedStorage->has('tracking_code')) {
            $this->assertEmailContainsMessageTo(
                $this->sharedStorage->get('tracking_code'),
                $recipient
            );
        }
    }


    private function assertEmailContainsMessageTo(string $message, string $recipient): void
    {
        Assert::true($this->emailChecker->hasMessageTo($message, $recipient));
    }

    private function getShippingMethodName(OrderInterface $order): string
    {
        /** @var ShipmentInterface $shipment */
        $shipment = $order->getShipments()->first();
        if (false === $shipment) {
            throw new \LogicException('Order should have at least one shipment.');
        }

        return $shipment->getMethod()->getName();
    }
}
