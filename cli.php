#!/usr/bin/env php
<?php

use Winnetou\WinnetouConsoleCommand;

require_once __DIR__ . '/vendor/autoload.php';

$app = new \Symfony\Component\Console\Application();

$app->add(new WinnetouConsoleCommand());

$app->run();
