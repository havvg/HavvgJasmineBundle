<?php

namespace Havvg\Bundle\JasmineBundle;

interface JasmineSpecAwareBundleInterface
{
    /**
     * Returns a list of file names to be used as Jasmine spec files.
     *
     * @return string
     */
    public function getJasmineSpecs();
}