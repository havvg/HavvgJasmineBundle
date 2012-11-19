<?php

namespace Havvg\Bundle\JasmineBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('havvg_jasmine');

        $disableFixtures = array(
            'directory' => '',
            'web_path' => '',
        );

        $rootNode
            ->children()
                ->arrayNode('fixtures')
                ->info('The configuration options when using Jasmine jQuery fixture files.')
                ->treatNullLike($disableFixtures)
                ->treatFalseLike($disableFixtures)
                ->children()
                    ->scalarNode('directory')
                        ->isRequired()
                        ->info('The directory to load the fixture files from.')
                    ->end()
                    ->scalarNode('web_path')
                        ->isRequired()
                        ->defaultValue('/spec/javascripts/fixtures')
                        ->info('The web path you configured the fixtures to be loaded by Jasmine jQuery.')
                    ->end()
                    ->scalarNode('use_cache')
                        ->defaultFalse()
                        ->info('This enables file caching in the web directory by mirroring the fixture files.')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
