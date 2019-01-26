#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

$containerBuilder = new ContainerBuilder();

$loader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__.'/../config/'));
$loader->load('dependencies.php');

$app = new Application('BLDR Benchmark app', 'v1.0.0');
$app->add($containerBuilder->get('app.ui.cli.command.run_benchmark_command'));
$app->run();
