<?php

use App\Application\Command\Report\GenerateReportCommandHandler;
use App\Application\EventSubscriber\Benchmark\WebsiteLoadedSlowerEventSubscriber;
use App\Domain\Benchmark\Service\PerformBenchmarkService;
use App\Domain\Report\Command\GenerateReportCommand;
use App\Infrastructure\Notification\Email\Adapter\SwiftMailer;
use App\Infrastructure\Notification\Email\Service\EmailService;
use App\Infrastructure\Notification\Sms\Adapter\NexmoGateway;
use App\Infrastructure\Notification\Sms\Service\SmsService;
use App\UI\Cli\Command\RunBenchmarkCommand;
use League\Tactician\Setup\QuickStart;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;

$dispatcher = new EventDispatcher();
$container
    ->register('event_dispatcher', EventDispatcher::class);

$commandBus = QuickStart::create([
    GenerateReportCommand::class => new GenerateReportCommandHandler(
        $container->get('event_dispatcher')
    ),
]);

$container
    ->set('tactician.commandBus', $commandBus);

$container
    ->register('question_helper', QuestionHelper::class);

$container
    ->register('perform_benchmark_service', PerformBenchmarkService::class);

$container
    ->register('run_benchmark_command', RunBenchmarkCommand::class)
    ->addArgument(new Reference('question_helper'))
    ->addArgument(new Reference('perform_benchmark_service'))
    ->addArgument(new Reference('tactician.commandBus'));

$container
    ->register('generate_report_command_handler', GenerateReportCommandHandler::class)
    ->addTag('tactician.handler', ['command' => GenerateReportCommand::class])
    ->addArgument(new Reference('event_dispatcher'));

$container
    ->setParameter('email_service.mailer', SwiftMailer::class);

$container
    ->register('email_service', EmailService::class)
    ->addArgument('%email_service.mailer%');

$container
    ->setParameter('sms_service.gateway', NexmoGateway::class);

$container
    ->register('sms_service', SmsService::class)
    ->addArgument('%sms_service.gateway%');

$container
    ->register('website_loaded_slower_event_subscriber', WebsiteLoadedSlowerEventSubscriber::class)
    ->addTag('kernel.event_subscriber')
    ->addArgument(new Reference('email_service'))
    ->addArgument(new Reference('sms_service'));
