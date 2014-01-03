<?php

namespace Havvg\Bundle\JasmineBundle\Controller;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FixturesController
{
    protected $fixturesDirectory;
    protected $cacheDirectory;

    public function __construct($fixturesDirectory)
    {
        $this->fixturesDirectory = $fixturesDirectory;
    }

    public function fixtureAction($file)
    {
        $realpath = realpath($this->fixturesDirectory.'/'.$file);

        if (!$realpath or !file_exists($realpath)) {
            throw new NotFoundHttpException(sprintf('The fixture file "%s" could not be found.', $realpath));
        }

        $content = file_get_contents($realpath);
        if ($cacheDir = $this->getCacheDirectory()) {
            $filename = str_replace('//', '/', $this->getCacheDirectory().'/'.$file);

            $path = pathinfo($filename);

            $fs = new Filesystem();
            $fs->mkdir($path['dirname']);
            $fs->touch($filename);

            file_put_contents($filename, $content);
        }

        return new Response($content);
    }

    public function setCacheDirectory($cacheDirectory)
    {
        $this->cacheDirectory = $cacheDirectory;

        return $this;
    }

    public function getCacheDirectory()
    {
        return $this->cacheDirectory;
    }
}
