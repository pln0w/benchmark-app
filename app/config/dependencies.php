<?php


use App\Application\Command\Report\GenerateReportCommandHandler;
use App\Application\EventSubscriber\Benchmark\WebsiteLoadedSlowerEventSubscriber;
use App\Application\Service\Benchmark\LogBenchmarkResultService;
use App\Application\Service\Benchmark\TimeMeasurementService;
use App\Application\Service\Http\GuzzleHttpClient;
use App\Application\Service\Http\HttpClientService;
use App\Domain\Benchmark\Service\PerformBenchmarkService;
use App\Domain\Report\Command\GenerateReportCommand;
use App\Domain\Report\Service\GenerateReportService;
use App\Infrastructure\Notification\Email\Adapter\SwiftMailer;
use App\Infrastructure\Notification\Email\Service\EmailService;
use App\Infrastructure\Notification\Sms\Adapter\NexmoGateway;
use App\Infrastructure\Notification\Sms\Service\SmsService;
use App\UI\Cli\Command\RunBenchmarkCommand;
use App\UI\Cli\Service\ConsoleOutputService;
use App\UI\Cli\Service\ConsoleReportOutputAdapterService;
use App\UI\Http\Web\Service\WebReportOutputAdapterService;
use League\Tactician\Setup\QuickStart;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\DependencyInjection\RegisterListenersPass;
use Symfony\Component\EventDispatcher\EventDispatcher;


$container
    ->register('email_service.swift_mailer', SwiftMailer::class);

$container
    ->register('email_service', EmailService::class)
    ->addArgument(new Reference('email_service.swift_mailer'));

$container
    ->register('sms_service.nexmo_gateway', NexmoGateway::class);

$container
    ->register('sms_service', SmsService::class)
    ->addArgument(new Reference('sms_service.nexmo_gateway'));

$websiteLoadedSlowerEventSubscriber = new WebsiteLoadedSlowerEventSubscriber(
    $container->get('email_service'),
    $container->get('sms_service'),
);

$container->addCompilerPass(new RegisterListenersPass());
$dispatcher = new EventDispatcher();
$dispatcher->addSubscriber($websiteLoadedSlowerEventSubscriber);

$container
    ->set('event_dispatcher', $dispatcher);

$container
    ->register('generate_report_service', GenerateReportService::class);

$commandBus = QuickStart::create([
    GenerateReportCommand::class => new GenerateReportCommandHandler(
        $container->get('event_dispatcher'),
        $container->get('generate_report_service')
    ),
]);

$container
    ->set('tactician.commandBus', $commandBus);

$container
    ->register('question_helper', QuestionHelper::class);

$container
    ->register('time_measurement_service', TimeMeasurementService::class);

$container
    ->register('http_client_service', HttpClientService::class);

$container
    ->register('log_benchmark_result', LogBenchmarkResultService::class);

$container
    ->register('perform_benchmark_service', PerformBenchmarkService::class)
    ->addArgument(new Reference('time_measurement_service'))
    ->addArgument(new Reference('http_client_service'))
    ->addArgument(new Reference('log_benchmark_result'));

$container
    ->register('run_benchmark_command', RunBenchmarkCommand::class)
    ->addArgument(new Reference('question_helper'))
    ->addArgument(new Reference('perform_benchmark_service'))
    ->addArgument(new Reference('tactician.commandBus'));

$container
    ->register('generate_report_command_handler', GenerateReportCommandHandler::class)
    ->addTag('tactician.handler', [
        'command' => GenerateReportCommand::class,
    ])
    ->addArgument(new Reference('event_dispatcher'))
    ->addArgument(new Reference('generate_report_service'));

$container
    ->register('console_report_output_adapter_service', ConsoleReportOutputAdapterService::class);

$container
    ->register('web_report_output_adapter_service', WebReportOutputAdapterService::class);

$container
    ->register('guzzle_http_client', GuzzleHttpClient::class);

$container
    ->register('http_client_service', HttpClientService::class)
    ->addArgument(new Reference('guzzle_http_client'));

$container
    ->register('website_loaded_slower_event_subscriber', WebsiteLoadedSlowerEventSubscriber::class)
    ->addTag('kernel.event_subscriber')
    ->addArgument(new Reference('email_service'))
    ->addArgument(new Reference('sms_service'));
