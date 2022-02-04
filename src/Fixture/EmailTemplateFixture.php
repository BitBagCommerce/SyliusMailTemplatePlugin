<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMailTemplatePlugin\Fixture;

use BitBag\SyliusMailTemplatePlugin\Fixture\Factory\FixtureFactoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class EmailTemplateFixture extends AbstractFixture
{
    private FixtureFactoryInterface $emailTemplateFixtureFactory;

    public function __construct(FixtureFactoryInterface $emailTemplateFixtureFactory)
    {
        $this->emailTemplateFixtureFactory = $emailTemplateFixtureFactory;
    }

    public function load(array $options): void
    {
        $this->emailTemplateFixtureFactory->load($options['custom']);
    }

    public function getName(): string
    {
        return 'email_template';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        /** @phpstan-ignore-next-line  */
        $optionsNode
            ->children()
                ->arrayNode('custom')
                    ->prototype('array')
                        ->children()
                            ->booleanNode('remove_existing')->defaultTrue()->end()
                            ->scalarNode('type')->defaultNull()->end()
                            ->scalarNode('styleCss')->defaultNull()->end()
                            ->arrayNode('translations')
                                ->prototype('array')
                                    ->children()
                                    ->scalarNode('name')->defaultNull()->end()
                                    ->scalarNode('subject')->defaultNull()->end()
                                    ->scalarNode('content')->defaultNull()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
