<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\EventListener;

use BitBag\SyliusMailTemplatePlugin\Provider\CustomTwigErrorResponseProviderInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Twig\Error\Error;

class TwigErrorEventListener
{
    private CustomTwigErrorResponseProviderInterface $customResponseProvider;

    public function __construct(CustomTwigErrorResponseProviderInterface $customResponseProvider)
    {
        $this->customResponseProvider = $customResponseProvider;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $error = $event->getThrowable();
        if (!$error instanceof Error) {
            return;
        }

        $customTwigErrorResponse = $this->customResponseProvider->provide($error);

        if (null === $customTwigErrorResponse) {
            return;
        }

        $event->setResponse($customTwigErrorResponse);
    }
}
