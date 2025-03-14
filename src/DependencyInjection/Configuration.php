<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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

        /** @phpstan-ignore-next-line */
        $rootNode
            ->children()
                 ->arrayNode('resources')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('driver')->isRequired()->end()
                            ->arrayNode('classes')
                                ->children()
                                    ->scalarNode('model')->isRequired()->end()
                                    ->scalarNode('interface')->defaultNull()->end()
                                    ->scalarNode('form')->defaultNull()->end()
                                ->end()
                            ->end()
                            ->arrayNode('translation')
                                ->children()
                                    ->arrayNode('classes')
                                        ->children()
                                            ->scalarNode('model')->isRequired()->end()
                                            ->scalarNode('interface')->defaultNull()->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
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
            ->end();

        return $treeBuilder;
    }
}
