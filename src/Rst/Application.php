<?php

/*
 * This file is part of the php-rst package.
 *
 * (c) Peter Kokot <peterkokot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rst;

use Symfony\Component\Console\Application as BaseApplication;
use Rst\Command\FixCommand;
use Rst\Command\CompileCommand;
use Rst\Command\SelfUpdateCommand;

class Application extends BaseApplication
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        error_reporting(-1);

        parent::__construct('PHP reStructuredText', '1.0-dev');

        $this->add(new FixCommand());
        $this->add(new CompileCommand());
        $this->add(new SelfUpdateCommand());
    }
}
