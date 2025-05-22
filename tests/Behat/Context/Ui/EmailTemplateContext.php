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
use Sylius\Behat\Service\Checker\EmailCheckerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;
use Webmozart\Assert\Assert;

final class EmailTemplateContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    private EmailCheckerInterface $emailChecker;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        EmailCheckerInterface $emailChecker,
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->emailChecker = $emailChecker;
    }

    /**
     * @Then it should be sent to :recipient
     */
    public function itShouldBeSentTo(string $recipient): void
    {
        Assert::true($this->emailChecker->hasRecipient($recipient));
    }

    /**
     * @Then a custom email with contact request should have been sent to :recipient with sender :sender
     */
    public function aCustomEmailShouldBeSentTo(string $recipient, string $sender): void
    {
        $this->assertEmailContainsMessageTo(
            sprintf(
                '%s wrote %s',
                $sender,
                'Hi! I did not receive an item!',
            ),
            $recipient,
        );
    }

    /**
     * @Then a default email with contact request should have been sent to :recipient with sender :sender
     */
    public function aDefaultEmailShouldBeSentTo(string $recipient, string $sender): void
    {
        $this->assertEmailContainsMessageTo(
            sprintf(
                '%s: %s %s: %s',
                'Message from',
                $sender,
                'Content',
                'Hi! I did not receive an item!',
            ),
            $recipient,
        );
    }

    /**
     * @Then a default email with reset token should be sent to :recipient
     * @Then a default email with reset token should be sent to :recipient in :localeCode locale
     */
    public function aDefaultEmailWithResetTokenShouldBeSentTo(string $recipient, string $localeCode = 'en_US'): void
    {
        $this->assertEmailContainsMessageTo(
            'To reset your password - click the link below',
            $recipient,
        );
    }

    /**
     * @Then a custom email with reset token should be sent to :recipient
     * @Then a custom email with reset token should be sent to :recipient in :localeCode locale
     */
    public function aCustomEmailWithResetTokenShouldBeSentTo(string $recipient, string $localeCode = 'en_US'): void
    {
        $this->assertEmailContainsMessageTo(
            'Wanna reset password? Here is your code:',
            $recipient,
        );
    }

    /**
     * @Then an email with the :method shipment's confirmation for the :orderNumber order should be sent to :email
     */
    public function anEmailWithShipmentsConfirmationForTheOrderShouldBeSentTo(
        string $method,
        string $orderNumber,
        string $recipient,
    ): void {
        Assert::true($this->emailChecker->hasMessageTo(
            sprintf(
                'Your order with number %s has been sent using %s.',
                $orderNumber,
                $method,
            ),
            $recipient,
        ));
    }

    /**
     * @Then a default account verification email should have been sent to :recipient
     */
    public function aDefaultAccountVerificationEmailShouldHaveBeenSentTo(string $recipient): void
    {
        $this->assertEmailContainsMessageTo(
            'To verify your email address - click the link below',
            $recipient,
        );
    }

    /**
     * @Then a custom account verification email should have been sent to :recipient
     */
    public function aCustomAccountVerificationEmailShouldHaveBeenSentTo(string $recipient): void
    {
        $this->assertEmailContainsMessageTo(
            'Verify yourself. We need you!',
            $recipient,
        );
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
            $recipient,
        );
    }

    /**
     * @Then a default welcoming email should have been sent to :recipient
     * @Then a default welcoming email should have been sent to :recipient in :localeCode locale
     */
    public function aDefaultWelcomingEmailShouldHaveBeenSentTo(string $recipient, string $localeCode = 'en_US'): void
    {
        $this->assertEmailContainsMessageTo(
            'To verify your email address - click the link below',
            $recipient,
        );
    }

    /**
     * @Then an email with the confirmation of the order :order should be sent to :email
     * @Then an email with the confirmation of the order :order should be sent to :email in :localeCode locale
     */
    public function anEmailWithTheConfirmationOfTheOrderShouldBeSentTo(
        OrderInterface $order,
        string $recipient,
        string $localeCode = 'en_US',
    ): void {
        $this->assertEmailContainsMessageTo(
            sprintf(
                '%s %s',
                'Pif paf',
                $order->getNumber(),
            ),
            $recipient,
        );
    }

    /**
     * @Then a default email with the confirmation of the order :order should be sent to :email
     * @Then a default email with the confirmation of the order :order should be sent to :email in :localeCode locale
     */
    public function aDefaultEmailWithTheConfirmationOfTheOrderShouldBeSentTo(
        OrderInterface $order,
        string $recipient,
        string $localeCode = 'en_US',
    ): void {
        $this->assertEmailContainsMessageTo(
            sprintf(
                '%s %s %s',
                'Your order no.',
                $order->getNumber(),
                'has been successfully placed.',
            ),
            $recipient,
        );
    }

    /**
     * @Then /^an email with the summary of (order placed by "[^"]+") should be sent to him$/
     * @Then /^an email with the summary of (order placed by "[^"]+") should be sent to him in ("([^"]+)" locale)$/
     */
    public function anEmailWithSummaryOfOrderPlacedByShouldBeSentTo(OrderInterface $order, string $localeCode = 'en_US'): void
    {
        /** @var ?CustomerInterface $customer */
        $customer = $order->getCustomer();
        Assert::notNull($customer);

        /** @var ?string $email */
        $email = $customer->getEmailCanonical();
        Assert::notNull($email);

        $this->anEmailWithTheConfirmationOfTheOrderShouldBeSentTo($order, $email, $localeCode);
    }

    /**
     * @Then /^a default email with the summary of (order placed by "[^"]+") should be sent to him$/
     * @Then /^a default email with the summary of (order placed by "[^"]+") should be sent to him in ("([^"]+)" locale)$/
     */
    public function aDefaultEmailWithSummaryOfOrderPlacedByShouldBeSentTo(OrderInterface $order, string $localeCode = 'en_US'): void
    {
        /** @var ?CustomerInterface $customer */
        $customer = $order->getCustomer();
        Assert::notNull($customer);

        /** @var ?string $email */
        $email = $customer->getEmailCanonical();
        Assert::notNull($email);

        $this->aDefaultEmailWithTheConfirmationOfTheOrderShouldBeSentTo($order, $email, $localeCode);
    }

    /**
     * @Then /^a default email with shipment's details of (this order) should be sent to "([^"]+)"$/
     * @Then /^a default email with shipment's details of (this order) should be sent to "([^"]+)" in ("([^"]+)" locale)$/
     */
    public function aDefaultEmailWithShipmentDetailsOfOrderShouldBeSentTo(
        OrderInterface $order,
        string $recipient,
        string $localeCode = 'en_US',
    ): void {
        $this->assertEmailContainsMessageTo(
            'Thank you for a successful transaction.',
            $recipient,
        );
    }

    /**
     * @Then /^a custom email with shipment's details of (this order) should be sent to "([^"]+)"$/
     * @Then /^a custom email with shipment's details of (this order) should be sent to "([^"]+)" in ("([^"]+)" locale)$/
     * @Then an email with the shipment's confirmation of the order :order should be sent to :recipient
     * @Then an email with the shipment's confirmation of the order :order should be sent to :recipient in :localeCode locale
     */
    public function anEmailWithShipmentDetailsOfOrderShouldBeSentTo(
        OrderInterface $order,
        string $recipient,
        string $localeCode = 'en_US',
    ): void {
        $this->assertEmailContainsMessageTo(
            sprintf(
                '%s %s %s',
                'Enjoy your new stuff!',
                $order->getNumber(),
                $this->getShippingMethodName($order),
            ),
            $recipient,
        );

        if ($this->sharedStorage->has('tracking_code')) {
            $this->assertEmailContainsMessageTo(
                $this->sharedStorage->get('tracking_code'),
                $recipient,
            );
        }
    }

    private function assertEmailContainsMessageTo(string $message, string $recipient): void
    {
        Assert::true($this->emailChecker->hasMessageTo($message, $recipient));
    }

    private function getShippingMethodName(OrderInterface $order): string
    {
        /** @var ShipmentInterface|false $shipment */
        $shipment = $order->getShipments()->first();
        if (false === $shipment) {
            throw new \LogicException('Order should have at least one shipment.');
        }

        /** @var ?ShippingMethodInterface $shippingMethod */
        $shippingMethod = $shipment->getMethod();
        Assert::notNull($shippingMethod);

        Assert::notNull($shippingMethod->getName());

        return $shippingMethod->getName();
    }
}
