<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
