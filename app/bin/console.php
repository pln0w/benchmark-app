#!/usr/bin/env php
<?php

require_once __DIR__ . '../vendor/autoload.php';

use Symfony\Component\Console\Application;
//use Console\TimeCommand;

$app = new Application('BL;DR Benchmark app', 'v1.0.0');
//$app -> add(new TimeCommand());
$app->run();
