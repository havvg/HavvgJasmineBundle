<?php

namespace Havvg\Bundle\JasmineBundle\Tests\Functional;

/**
 * @runTestsInSeparateProcesses
 */
class ConfigurationTest extends FunctionalTestCase
{
    public function testBootableWithDefaultConfiguration()
    {
        static::$kernel = static::createKernel(array('config_file' => 'empty.yml'));
        static::$kernel->boot();
    }

    public function testBootableWithCacheEnabled()
    {
        static::$kernel = static::createKernel(array('config_file' => 'fixtures_cache_enabled.yml'));
        static::$kernel->boot();
    }
}
