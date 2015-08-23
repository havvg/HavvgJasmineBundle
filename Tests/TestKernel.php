<?php

namespace Havvg\Bundle\JasmineBundle\Tests;

use Havvg\Bundle\JasmineBundle\HavvgJasmineBundle;
use Symfony\Bundle\AsseticBundle\AsseticBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    /**
     * @var string
     */
    private $configFilename;

    /**
     * @var string
     */
    private $tmpDir;

    /**
     * Constructor.
     *
     * @param string $configFilename
     * @param string $environment
     * @param bool   $debug
     */
    public function __construct($configFilename, $environment = 'test', $debug = true)
    {
        $this->configFilename = $configFilename;
        $this->tmpDir = sys_get_temp_dir().'/havvg_jasmine_tests';

        parent::__construct($environment, $debug);
    }

    /**
     * Destructor.
     *
     * Removes all temporary files.
     */
    public function __destruct()
    {
        $fs = new Filesystem();
        $fs->remove($this->tmpDir);
    }

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return array(
            new FrameworkBundle(),
            new AsseticBundle(),

            new HavvgJasmineBundle(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/fixtures/config/'.$this->configFilename);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return $this->tmpDir.'/cache';
    }

    /**
     * {@inheritdoc}
     */
    public function getLogDir()
    {
        return $this->tmpDir.'/logs';
    }
}
