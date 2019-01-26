#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\UI\Cli\Command\RunBenchmarkCommand;
use Symfony\Component\Console\Helper\QuestionHelper;

$app = new Application('BLDR Benchmark app', 'v1.0.0');
$app->add(new RunBenchmarkCommand(new QuestionHelper));
$app->run();
