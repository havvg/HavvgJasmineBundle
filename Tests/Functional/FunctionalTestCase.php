<?php

namespace Havvg\Bundle\JasmineBundle\Tests\Functional;

use Havvg\Bundle\JasmineBundle\Tests\TestKernel;

abstract class FunctionalTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TestKernel
     */
    protected static $kernel;

    public static function setUpBeforeClass()
    {
        if (null !== static::$kernel) {
            static::$kernel->shutdown();
        }
    }

    protected function tearDown()
    {
        if (null !== static::$kernel) {
            static::$kernel->shutdown();
        }
    }

    /**
     * Creates a TestKernel to be used within a functional test.
     *
     * Available options:
     *
     *  * config_file (The configuration file to boot the kernel with, required.)
     *  * environment
     *  * debug
     *
     * @param array $options A list of options to configure creation of the kernel.
     *
     * @return TestKernel
     */
    protected static function createKernel(array $options = array())
    {
        if (empty($options['config_file'])) {
            throw new \RuntimeException('The "config_file" option is required to create the TestKernel.');
        }

        return new TestKernel(
            $options['config_file'],
            isset($options['environment']) ? $options['environment'] : 'test',
            isset($options['debug']) ? $options['debug'] : true
        );
    }
}
