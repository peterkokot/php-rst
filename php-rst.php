#!/usr/bin/env php
<?php

/*
 * This file is part of the php-rst package.
 *
 * (c) Peter Kokot <peterkokot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/vendor/autoload.php';

use Rst\Command\FixCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->run();
