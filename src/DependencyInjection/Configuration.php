<?php

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress UnusedVariable
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('bitbag_sylius_mail_template_plugin');
        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
