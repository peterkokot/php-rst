<?php

/*
 * This file is part of the phprst package.
 *
 * (c) Peter Kokot <peterkokot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rst\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Rst\Fixer;

class FixCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('fix')
            ->setDescription('Fix reStructuredText')
            ->addArgument(
                'files',
                InputArgument::REQUIRED,
                'Add the location of reStructuredText files.'
            )
            ->addOption(
               'yell',
               null,
               InputOption::VALUE_NONE,
               'If set, the task will yell in uppercase letters'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $files = $input->getArgument('files');
        
        $fixer = new Fixer($files);
        $fixer->fix();
        $text = $fixer->getReport();

        $output->writeln($text);
    }
}
