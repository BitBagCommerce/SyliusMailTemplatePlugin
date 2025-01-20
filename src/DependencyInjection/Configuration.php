<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email at hello@bitbag.io.
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
     * Builds the configuration tree for the plugin.
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::TREE_NAME);
        $rootNode = $treeBuilder->getRootNode();

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

                // Configuration for resources
//                ->arrayNode('resources')
//                    ->addDefaultsIfNotSet()
//                    ->children()
//                        ->arrayNode('email_template')
//                            ->addDefaultsIfNotSet()
//                            ->children()
//                                ->scalarNode('model')
//                                    ->defaultValue('BitBag\SyliusMailTemplatePlugin\Entity\MailTemplate')
//                                    ->info('The FQCN of the MailTemplate model.')
//                                ->end()
//                                ->scalarNode('repository')
//                                    ->defaultValue('BitBag\SyliusMailTemplatePlugin\Repository\MailTemplateRepository')
//                                    ->info('The FQCN of the repository for MailTemplate.')
//                                ->end()
//                                ->scalarNode('interface')
//                                    ->defaultValue('BitBag\SyliusMailTemplatePlugin\Entity\MailTemplateInterface')
//                                    ->info('The FQCN of the MailTemplate interface.')
//                                ->end()
//                                ->scalarNode('form')
//                                    ->defaultValue('BitBag\SyliusMailTemplatePlugin\Form\Type\MailTemplateType')
//                                    ->info('The FQCN of the form type for MailTemplate.')
//                                ->end()
//                            ->end()
//                        ->end()
//                    ->end()
//                ->end()

                // Configuration for Twig integration
                ->arrayNode(self::TWIG)
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode(self::ALLOWED_FILTERS)
                            ->useAttributeAsKey('name')
                            ->defaultValue([])
                            ->prototype('scalar')->end()
                            ->info('Allowed Twig filters.')
                        ->end()
                        ->arrayNode(self::ALLOWED_FUNCTIONS)
                            ->useAttributeAsKey('name')
                            ->defaultValue([])
                            ->prototype('scalar')->end()
                            ->info('Allowed Twig functions.')
                        ->end()
                        ->arrayNode(self::ALLOWED_METHODS)
                            ->useAttributeAsKey('name')
                            ->defaultValue(self::ALLOWED_METHODS_DEFAULT)
                            ->prototype('scalar')->end()
                            ->info('Allowed Twig methods.')
                        ->end()
                        ->arrayNode(self::ALLOWED_PROPERTIES)
                            ->useAttributeAsKey('name')
                            ->defaultValue([])
                            ->prototype('scalar')->end()
                            ->info('Allowed Twig properties.')
                        ->end()
                        ->arrayNode(self::ALLOWED_TAGS)
                            ->useAttributeAsKey('name')
                            ->defaultValue([])
                            ->prototype('scalar')->end()
                            ->info('Allowed Twig tags.')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
