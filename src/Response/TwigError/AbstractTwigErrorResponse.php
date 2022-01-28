<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
        Assert::isInstanceOf($error, $this->getSupportedErrorClass());

        return new JsonResponse(
            [
                'message' => $this->getErrorMessage($error),
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    public function supports(Error $error): bool
    {
        return get_class($error) === $this->getSupportedErrorClass();
    }
}
