<?php

/*
 * This file is part of the php-rst package.
 *
 * (c) Peter Kokot <peterkokot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rst\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Rst\Util\Compiler;

class CompileCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('compile')
            ->setDescription('Compiles this library into a phar file.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $compiler = new Compiler();
        $compiler->compile();
    }
}
