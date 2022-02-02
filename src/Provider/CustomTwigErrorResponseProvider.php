<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Provider;

use BitBag\SyliusMailTemplatePlugin\Response\TwigError\TwigErrorResponseInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Error\Error;
use Webmozart\Assert\Assert;

final class CustomTwigErrorResponseProvider implements CustomTwigErrorResponseProviderInterface
{
    /** @var TwigErrorResponseInterface[] */
    private array $customTwigErrorResponses;

    public function __construct(iterable $customTwigErrorResponses)
    {
        $this->customTwigErrorResponses = $customTwigErrorResponses instanceof \Traversable ? iterator_to_array($customTwigErrorResponses) : $customTwigErrorResponses;
    }

    public function provide(Error $error): ?Response
    {
        foreach ($this->customTwigErrorResponses as $response) {
            Assert::same(get_class($response), TwigErrorResponseInterface::class);

            if ($response->supports($error)) {
                return $response->getResponse($error);
            }
        }

        return null;
    }
}
