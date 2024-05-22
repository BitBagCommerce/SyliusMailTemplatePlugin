<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class BitBagSyliusMailTemplateExtension extends Extension
{
    public const ALLOWED_FILTERS_PARAMETER = 'bitbag_sylius_mail_template_plugin.mail_template.twig.allowed_filters';

    public const ALLOWED_FUNCTIONS_PARAMETER = 'bitbag_sylius_mail_template_plugin.mail_template.twig.allowed_functions';

    public const ALLOWED_METHODS_PARAMETER = 'bitbag_sylius_mail_template_plugin.mail_template.twig.allowed_methods';

    public const ALLOWED_PROPERTIES_PARAMETER = 'bitbag_sylius_mail_template_plugin.mail_template.twig.allowed_properties';

    public const ALLOWED_TAGS_PARAMETER = 'bitbag_sylius_mail_template_plugin.mail_template.twig.allowed_tags';

    public const REQUIRED_FILTERS = ['nl2br', 'inky_to_html', 'escape'];

    public const REQUIRED_FUNCTIONS = ['include', 'template_from_string'];

    public const REQUIRED_TAGS = ['apply'];

    /**
     * @psalm-suppress UnusedVariable
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');

        $container->setParameter(
            self::ALLOWED_FILTERS_PARAMETER,
            array_unique(array_merge($config[Configuration::TWIG][Configuration::ALLOWED_FILTERS], self::REQUIRED_FILTERS)),
        );
        $container->setParameter(
            self::ALLOWED_FUNCTIONS_PARAMETER,
            array_unique(array_merge($config[Configuration::TWIG][Configuration::ALLOWED_FUNCTIONS], self::REQUIRED_FUNCTIONS)),
        );
        $container->setParameter(
            self::ALLOWED_METHODS_PARAMETER,
            $config[Configuration::TWIG][Configuration::ALLOWED_METHODS],
        );
        $container->setParameter(
            self::ALLOWED_PROPERTIES_PARAMETER,
            $config[Configuration::TWIG][Configuration::ALLOWED_PROPERTIES],
        );
        $container->setParameter(
            self::ALLOWED_TAGS_PARAMETER,
            array_unique(array_merge($config[Configuration::TWIG][Configuration::ALLOWED_TAGS], self::REQUIRED_TAGS)),
        );
    }

    public function getConfiguration(array $config, ContainerBuilder $container): ConfigurationInterface
    {
        return new Configuration();
    }
}
