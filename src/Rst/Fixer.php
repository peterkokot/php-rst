<?php

/*
 * This file is part of the phprst package.
 *
 * (c) Peter Kokot <peterkokot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rst;

use Symfony\Component\Finder\Finder;

class Fixer
{
    private $folder;
    private $report = null;

    public function __construct($folder) {
        $this->folder = $folder;
    }

    public function fix()
    {
        $finder = new Finder();
        $finder->files()->in($this->folder);

        foreach ($finder as $file) {
            $content = file_get_contents($file->getRealpath());
            if (strpos($content, '.. `') !== false) {
                $this->report .= $file->getRealpath()."\n";
            }
        }
    }

    public function getReport()
    {
        return $this->report;
    }
}
