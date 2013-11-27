<?php

/*
 * This file is part of the php-rst package.
 *
 * (c) Peter Kokot <peterkokot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RST\Util;

use Symfony\Component\Finder\Finder;

/**
* The Compiler class compiles the php-rst utility.
*
* @author Peter Kokot <peterkokot@gmail.com>
*/
class Compiler
{
    public function compile($pharFile = 'php-rst.phar')
    {
        if (file_exists($pharFile)) {
            unlink($pharFile);
        }

        $phar = new \Phar($pharFile, 0, 'php-rst.phar');
        $phar->setSignatureAlgorithm(\Phar::SHA1);

        $phar->startBuffering();

        // CLI Component files
        foreach ($this->getFiles() as $file) {
            $path = str_replace(__DIR__.'/', '', $file);
            $phar->addFromString($path, file_get_contents($file));
        }
        $this->addRst($phar);

        // Stubs
        $phar->setStub($this->getStub());

        $phar->stopBuffering();

        // $phar->compressFiles(\Phar::GZ);

        unset($phar);

        chmod($pharFile, 0777);
    }

    /**
     * Remove the shebang from the file before add it to the PHAR file.
     *
     * @param \Phar $phar PHAR instance
     */
    protected function addPhpRst(\Phar $phar)
    {
        $content = file_get_contents(__DIR__ . '/../../../php-rst');
        $content = preg_replace('{^#!/usr/bin/env php\s*}', '', $content);

        $phar->addFromString('php-rst', $content);
    }

    protected function getStub()
    {
        return "#!/usr/bin/env php\n<?php Phar::mapPhar('php-rst.phar'); require 'phar://php-rst.phar/php-rst'; __HALT_COMPILER();";
    }

    protected function getLicense()
    {
        return '
    /*
     * This file is part of the php-rst package.
     *
     * (c) Peter Kokot <peterkokot@gmail.com>
     *
     * For the full copyright and license information, please view the LICENSE
     * file that was distributed with this source code.
     */';
    }

    protected function getFiles()
    {
        $iterator = Finder::create()->files()->exclude('Tests')->name('*.php')->in(array('vendor', 'Symfony'));

        return array_merge(array('LICENSE'), iterator_to_array($iterator));
    }
}
