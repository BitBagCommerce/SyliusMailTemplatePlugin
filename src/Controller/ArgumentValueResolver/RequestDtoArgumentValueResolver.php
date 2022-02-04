<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
