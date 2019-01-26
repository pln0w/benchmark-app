<?php

use App\UI\Cli\Command\RunBenchmarkCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\DependencyInjection\Reference;

$container
    ->register('question_helper', QuestionHelper::class);

$container
    ->register('app.ui.cli.command.run_benchmark_command', RunBenchmarkCommand::class)
    ->addArgument(new Reference('question_helper'));
