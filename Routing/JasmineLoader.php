<?php

namespace Havvg\Bundle\JasmineBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class JasmineLoader extends Loader
{
    /**
     * The root directory to load fixture files from.
     *
     * @var string
     */
    protected $directory;

    /**
     * @var Finder
     */
    protected $finder;

    /**
     * The web path to use when generating each Route.
     *
     * @var string
     */
    protected $webPath;

    public function load($resource, $type = null)
    {
        $routes = new RouteCollection();

        $files = $this->getFinder();
        foreach ($files as $eachFile) {
            /* @var $eachFile \SplFileInfo */
            $fileName = trim(str_replace($this->getDirectory(), '', $eachFile->getRealPath()), '/');

            $route = rtrim(str_replace('//', '/', sprintf('/%s/%s/', $this->getWebPath(), $fileName)), '/');
            $routes->add('_jasmine_fixtures_'.sha1($fileName), new Route(
                $route,
                array(
                    '_controller' => 'havvg_jasmine.fixtures_controller:fixtureAction',
                    'file' => $fileName,
                ),
                array(
                    '_method' => 'GET',
                )
            ));
        }

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'jasmine' === $type;
    }

    public function setDirectory($directory)
    {
        $directory = realpath($directory);

        if (!is_dir($directory) or !is_readable($directory)) {
            throw new \InvalidArgumentException(sprintf('The directory "%s" is not accessible, make sure it exists and is readable.', $directory));
        }

        $this->directory = $directory;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function setFinder(Finder $finder)
    {
        $this->finder = $finder;

        return $this;
    }

    public function getFinder()
    {
        $this->createFinder();

        return $this->finder;
    }

    protected function createFinder()
    {
        if (!$this->finder) {
            $this->finder = new Finder();

            $this->finder
                ->in($this->getDirectory())
                ->files()
            ;
        }

        return $this;
    }

    public function setWebPath($webPath)
    {
        $this->webPath = $webPath;

        return $this;
    }

    public function getWebPath()
    {
        return $this->webPath;
    }
}
