<?php

/*
 * This file is part of the phprst package.
 *
 * (c) Peter Kokot <peterkokot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rst\Tests;

use Rst\Command\FixCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application;
use PHPUnit\Framework\TestCase;

class FixCommandTest extends TestCase
{
    public function testGetName()
    {
        $application = new Application();

        $application->add(new FixCommand());
        $commandName = $application
            ->find('fix')
            ->getName();

        $this->assertSame('fix', $commandName);
    }

    public function testGetDescription()
    {
        $application = new Application();

        $application->add(new FixCommand());
        $description = $application
            ->find('fix')
            ->getDescription();

        $this->assertSame('Fix reStructuredText', $description);
    }

    public function testExecute()
    {
        $application = new Application();

        $application->add(new FixCommand());
        $command = $application->find('fix');
        $commandTester = new CommandTester($command);
        $input = ['files' => __DIR__ . '/fixtures'];
        $commandTester->execute($input);

        $this->assertSame(__DIR__ . "/fixtures/sample.rst\n\n", $commandTester->getDisplay());
    }
}
