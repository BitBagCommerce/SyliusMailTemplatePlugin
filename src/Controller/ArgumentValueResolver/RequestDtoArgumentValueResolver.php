<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Controller\ArgumentValueResolver;

use BitBag\SyliusMailTemplatePlugin\Http\Exception\BadRequestException;
use BitBag\SyliusMailTemplatePlugin\Request\RequestDtoInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class RequestDtoArgumentValueResolver implements ArgumentValueResolverInterface
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType() ?? '', RequestDtoInterface::class);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        /** @var RequestDtoInterface|mixed $class */
        $class = $argument->getType();

        $requestDto = $class::createFromRequest($request);
        Assert::isInstanceOf($requestDto, RequestDtoInterface::class);

        $errors = $this->validator->validate($requestDto);
        if (0 < $errors->count()) {
            $firstError = $errors->get(0);
            $errorMessage = sprintf('%s: %s', $firstError->getPropertyPath(), $firstError->getMessage());

            throw new BadRequestException($errorMessage);
        }

        yield $requestDto;
    }
}
