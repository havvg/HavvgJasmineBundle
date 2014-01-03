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

        $rootNode
            ->children()
                ->scalarNode('asset_manager')
                    ->defaultValue('assetic.asset_manager')
                    ->info('The service id of an Assetic AssetManager to use.')
                ->end()
                ->scalarNode('template')
                    ->defaultValue('::jasmine.html.twig')
                    ->info('The template to render when requesting the JasmineController.')
                ->end()
                ->arrayNode('fixtures')
                ->info('The configuration options when using Jasmine jQuery fixture files.')
                ->children()
                    ->scalarNode('directory')
                        ->isRequired()
                        ->info('The directory to load the fixture files from.')
                    ->end()
                    ->scalarNode('web_path')
                        ->defaultValue('/spec/javascripts/fixtures')
                        ->info('The web path you configured the fixtures to be loaded by Jasmine jQuery.')
                    ->end()
                    ->booleanNode('use_cache')
                        ->defaultFalse()
                        ->info('This enables file caching in the web directory by mirroring the fixture files.')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
