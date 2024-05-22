<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Response\TwigError\TwigErrorResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\Error;
use Webmozart\Assert\Assert;

final class CustomTwigErrorResponseProvider implements CustomTwigErrorResponseProviderInterface
{
    /** @var TwigErrorResponseInterface[]|object[] */
    private array $customTwigErrorResponses;

    public function __construct(iterable $customTwigErrorResponses)
    {
        $this->customTwigErrorResponses = $customTwigErrorResponses instanceof \Traversable ? iterator_to_array($customTwigErrorResponses) : $customTwigErrorResponses;
    }

    public function provide(Error $error): ?Response
    {
        foreach ($this->customTwigErrorResponses as $response) {
            Assert::isInstanceOf($response, TwigErrorResponseInterface::class);

            if ($response->supports($error)) {
                return $response->getResponse($error);
            }
        }

        return null;
    }
}
