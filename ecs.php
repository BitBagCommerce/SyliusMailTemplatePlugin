<?php

use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import('vendor/bitbag/coding-standard/ecs.php');

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/spec',
    ]);
    $parameters->set(Option::SKIP, [
        __DIR__ . '/tests/Application',
        VisibilityRequiredFixer::class => ['*Spec.php'],
    ]);
};
