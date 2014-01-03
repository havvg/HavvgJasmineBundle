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

        $container->setAlias('havvg_jasmine.asset_manager', $config['asset_manager']);
        $container->setParameter('havvg_jasmine.template', $config['template']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/services'));
        $loader->load('services.yml');

        if (!empty($config['fixtures'])) {
            $container->setParameter('havvg_jasmine.fixtures.directory', $config['fixtures']['directory']);
            $container->setParameter('havvg_jasmine.fixtures.web_path', $config['fixtures']['web_path']);
            $container->setParameter('havvg_jasmine.fixtures.use_cache', $config['fixtures']['use_cache']);

            if ($config['fixtures']['use_cache']) {
                $controller = $container->getDefinition('havvg_jasmine.fixtures_controller');
                $controller->addMethodCall('setCacheDirectory', array($config['fixtures']['web_path']));
            }

            $loader->load('fixtures.yml');
        }
    }
}
