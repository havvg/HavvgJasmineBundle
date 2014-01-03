<?php

namespace Havvg\Bundle\JasmineBundle\Routing;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

class CacheClearer implements CacheClearerInterface
{
    protected $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    public function clear($cacheDir)
    {
        // $cacheDir refers to the application, it's not in use by the routing

        if ($directory = realpath($this->directory)) {
            $fs = new Filesystem();
            $fs->remove(Finder::create()->in($directory));
        }
    }
}
