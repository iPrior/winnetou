#!/usr/bin/env php
<?php
require_once __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config.php';

$winnetouConfig = \Winnetou\WinnetouConfigVO::createFromArray($config);
$winnetou = new \Winnetou\Winnetou($winnetouConfig);

$result = $winnetou->createWorkLog();

print_r($result);
