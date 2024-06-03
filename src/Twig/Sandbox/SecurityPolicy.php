<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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
        $functions,
    ): void {
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
