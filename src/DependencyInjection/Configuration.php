<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public const TREE_NAME = 'bit_bag_sylius_mail_template';

    public const TWIG = 'twig';

    public const ALLOWED_FILTERS = 'allowed_filters';

    public const ALLOWED_FUNCTIONS = 'allowed_functions';

    public const ALLOWED_METHODS = 'allowed_methods';

    public const ALLOWED_PROPERTIES = 'allowed_properties';

    public const ALLOWED_TAGS = 'allowed_tags';

    public const ALLOWED_METHODS_DEFAULT = ['*' => '*'];

    /**
     * @psalm-suppress UnusedVariable
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::TREE_NAME);
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode(self::TWIG)
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode(self::ALLOWED_FILTERS)
                            ->useAttributeAsKey('name')
                            ->defaultValue([])
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode(self::ALLOWED_FUNCTIONS)
                            ->useAttributeAsKey('name')
                            ->defaultValue([])
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode(self::ALLOWED_METHODS)
                            ->useAttributeAsKey('name')
                            ->defaultValue(self::ALLOWED_METHODS_DEFAULT)
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode(self::ALLOWED_PROPERTIES)
                            ->useAttributeAsKey('name')
                            ->defaultValue([])
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode(self::ALLOWED_TAGS)
                            ->useAttributeAsKey('name')
                            ->defaultValue([])
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
