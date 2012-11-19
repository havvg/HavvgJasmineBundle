<?php

namespace Havvg\Bundle\JasmineBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class HavvgJasmineExtension extends Extension
{
    /**
     * Loads the configuration.
     *
     * @param array            $configs   An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor     = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        if (!empty($config['fixtures']) and !empty($config['fixtures']['directory'])) {
            $container->setParameter('havvg_jasmine.fixtures.directory', $config['fixtures']['directory']);
            $container->setParameter('havvg_jasmine.fixtures.web_path', $config['fixtures']['web_path']);
            $container->setParameter('havvg_jasmine.fixtures.use_cache', $config['fixtures']['use_cache']);

            $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/services'));
            $loader->load('fixtures.yml');
        }
    }
}
