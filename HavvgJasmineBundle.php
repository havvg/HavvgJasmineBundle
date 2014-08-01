<?php

namespace Havvg\Bundle\JasmineBundle;

use Assetic\AssetManager;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Factory\LazyAssetManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

class HavvgJasmineBundle extends Bundle
{
    public function boot()
    {
        if (!class_exists('Assetic\AssetManager')) {
            return;
        }

        $assetManager = $this->container->get('havvg_jasmine.asset_manager', ContainerInterface::NULL_ON_INVALID_REFERENCE);
        if (!$assetManager instanceof AssetManager) {
            return;
        }

        $files = array();
        foreach ($this->container->get('kernel')->getBundles() as $eachBundle) {
            $files = array_merge($files, self::getJasmineSpecs($eachBundle));
        }

        if (empty($files)) {
            return;
        }

        $targetPath = $this->container->getParameter('havvg_jasmine.spec_target_path');

        $asset = new AssetCollection();
        $asset->setTargetPath($targetPath);

        foreach ($files as $eachFile) {
            $asset->add(new FileAsset($eachFile));
        }

        $assetManager = $this->container->get('assetic.asset_manager');
        $assetManager->set('havvg_jasmine_specs_js', $asset);

        if ($assetManager instanceof LazyAssetManager) {
            $assetManager->setFormula('havvg_jasmine_specs_js', array(
                $files,
                array()
            ));
        }
    }

    public static function getJasmineSpecs(BundleInterface $bundle)
    {
        if ($bundle instanceof JasmineSpecAwareBundleInterface) {
            return $bundle->getJasmineSpecs();
        }

        $specsDirectory = $bundle->getPath().'/Resources/jasmine/specs/';
        if (!is_dir($specsDirectory)) {
            return array();
        }

        $finder = new Finder();
        $finder
            ->name('*.js')
            ->in($specsDirectory)
        ;

        $files = array();
        foreach ($finder as $eachFile) {
            /* @var $eachFile \SplFileInfo */
            $files[] = $eachFile->getRealPath();
        }

        return $files;
    }
}
