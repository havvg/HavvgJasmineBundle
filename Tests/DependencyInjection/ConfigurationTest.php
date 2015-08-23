<?php

namespace Havvg\Bundle\JasmineBundle\Tests\DependencyInjection;

use Havvg\Bundle\JasmineBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

/**
 * @covers Havvg\Bundle\JasmineBundle\DependencyInjection\Configuration
 */
class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyConfigurationIsValid()
    {
        $config = self::process(new Configuration(), array());

        $expected = array(
            'asset_manager' => 'assetic.asset_manager',
            'template' => '::jasmine.html.twig',
            'spec_target_path' => '',
        );

        static::assertEquals($expected, $config);
    }

    public function testFixturesRequiresDirectory()
    {
        $this->setExpectedException('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException', 'The child node "directory" at path "havvg_jasmine.fixtures" must be configured.');

        self::process(new Configuration(), array(
            'havvg_jasmine' => array(
                'fixtures' => array(),
            ),
        ));
    }

    public function testFixturesDefaultValues()
    {
        $config = self::process(new Configuration(), array(
            'havvg_jasmine' => array(
                'fixtures' => array(
                    'directory' => '%kernel.root_dir%/Resources/jasmine/fixtures',
                ),
            ),
        ));

        $expected = array(
            'asset_manager' => 'assetic.asset_manager',
            'template' => '::jasmine.html.twig',
            'spec_target_path' => '',
            'fixtures' => array(
                'directory' => '%kernel.root_dir%/Resources/jasmine/fixtures',
                'web_path' => '/spec/javascripts/fixtures',
                'use_cache' => false,
            ),
        );

        static::assertEquals($expected, $config);
    }

    public static function process(Configuration $configuration, array $configs)
    {
        $processor = new Processor();

        return $processor->processConfiguration($configuration, $configs);
    }
}
