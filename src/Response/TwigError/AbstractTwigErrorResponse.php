<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Response\TwigError;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\Error;
use Webmozart\Assert\Assert;

abstract class AbstractTwigErrorResponse implements TwigErrorResponseInterface
{
    abstract protected function getSupportedErrorClass(): string;

    abstract protected function getErrorMessage(Error $error): string;

    public function getResponse(Error $error): Response
    {
        Assert::same(get_class($error), $this->getSupportedErrorClass());

        return new JsonResponse(
            [
                'message' => $this->getErrorMessage($error),
            ],
            Response::HTTP_BAD_REQUEST,
        );
    }

    public function supports(Error $error): bool
    {
        return get_class($error) === $this->getSupportedErrorClass();
    }
}
