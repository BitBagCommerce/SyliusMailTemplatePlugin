<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Twig\Sandbox;

use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedMethodError;
use Twig\Sandbox\SecurityNotAllowedPropertyError;
use Twig\Sandbox\SecurityPolicyInterface;

class SecurityPolicy implements SecurityPolicyInterface
{
    public const WILDCARD_CHARACTER = '*';

    private SecurityPolicyInterface $decoratedSecurityPolicy;

    private array $allowedMethods;

    public function __construct(SecurityPolicyInterface $decoratedSecurityPolicy, array $allowedMethods)
    {
        $this->decoratedSecurityPolicy = $decoratedSecurityPolicy;
        $this->allowedMethods = $allowedMethods;
    }

    /**
     * @param mixed $tags
     * @param mixed $filters
     * @param mixed $functions
     *
     * @throws SecurityError
     */
    public function checkSecurity(
        $tags,
        $filters,
        $functions
    ): void
    {
        $this->decoratedSecurityPolicy->checkSecurity($tags, $filters, $functions);
    }

    /**
     * @param mixed $obj
     * @param mixed $method
     *
     * @throws SecurityNotAllowedMethodError
     */
    public function checkMethodAllowed($obj, $method): void
    {
        foreach ($this->allowedMethods as $class => $allowedMethods) {
            if (!$obj instanceof $class && self::WILDCARD_CHARACTER !== $class) {
                continue;
            }

            if (self::WILDCARD_CHARACTER !== $allowedMethods && !$this->checkAllowedMethodsContainsClassWildcardWithMethod($method)) {
                continue;
            }

            return;
        }

        $this->decoratedSecurityPolicy->checkMethodAllowed($obj, $method);
    }

    private function checkAllowedMethodsContainsClassWildcardWithMethod(string $method): bool
    {
        if (!isset($this->allowedMethods[self::WILDCARD_CHARACTER])) {
            return false;
        }

        if (!is_array($this->allowedMethods[self::WILDCARD_CHARACTER])) {
            return false;
        }

        return in_array($method, $this->allowedMethods[self::WILDCARD_CHARACTER], true);
    }

    /**
     * @param mixed $obj
     * @param mixed $method
     *
     * @throws SecurityNotAllowedPropertyError
     */
    public function checkPropertyAllowed($obj, $method): void
    {
        $this->decoratedSecurityPolicy->checkPropertyAllowed($obj, $method);
    }
}
