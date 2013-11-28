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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SelfUpdateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('self-update')
            ->setDescription('Updates phprst to the latest version.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $remoteFilename = 'http://phprst.maastermedia.org/get/phprst.phar';
        $localFilename = $_SERVER['argv'][0];
        $tempFilename = basename($localFilename, '.phar').'-temp.phar';

        try {
            copy($remoteFilename, $tempFilename);

            if (md5_file($localFilename) == md5_file($tempFilename)) {
                $output->writeln('<info>phprst is already at the latest version.</info>');
                unlink($tempFilename);

                return;
            }

            chmod($tempFilename, 0777 & ~umask());

            // test the phar validity
            $phar = new \Phar($tempFilename);
            // free the variable to unlock the file
            unset($phar);
            rename($tempFilename, $localFilename);

            $output->writeln('<info>phprst updated.</info>');
        } catch (\Exception $e) {
            if (!$e instanceof \UnexpectedValueException && !$e instanceof \PharException) {
                throw $e;
            }
            unlink($tempFilename);
            $output->writeln('<error>The download is corrupt ('.$e->getMessage().').</error>');
            $output->writeln('<error>Please re-run the self-update command to try again.</error>');
        }
    }
}
