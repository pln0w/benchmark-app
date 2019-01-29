<?php

namespace Tests\UI\Cli\Command;

use App\Domain\Benchmark\Service\PerformBenchmarkService;
use App\Domain\Report\Factory\ReportAdapterStaticFactory;
use App\Domain\Url\ValueObject\Url;
use App\UI\Cli\Command\RunBenchmarkCommand;
use League\Tactician\CommandBus;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RunBenchmarkCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $url = 'test.com';
        $url2 = 'example.com';
        $url3 = 'admin.com';
        $competitors = "$url2, $url3";

        $mQuestionHelper = Mockery::mock(QuestionHelper::class);
        $mQuestionHelper->expects('ask')
                        ->times(3)
                        ->andReturnValues([
                            $url,
                            $competitors,
                            ReportAdapterStaticFactory::getDefaultTypeString(),
                        ]);

        $mPerformBenchmarkService = Mockery::mock(PerformBenchmarkService::class);
        $mPerformBenchmarkService->expects('run')
                                 ->times(3)
                                 ->with([
                                     new Url($url, false),
                                     new Url($url2, true),
                                     new Url($url3, true),
                                 ]);

        $mCommandBus = Mockery::mock(CommandBus::class);
        $mCommandBus->expects('handle')->withAnyArgs();

        $commandTester = new CommandTester(new RunBenchmarkCommand(
            $mQuestionHelper,
            $mPerformBenchmarkService,
            $mCommandBus
        ));

        $commandTester->execute([], []);

        $output = $commandTester->getDisplay();

        $this->assertContains(
            '==> testing '.$url, $output
        );
        $this->assertContains(
            '==> testing example.com', $output
        );
        $this->assertContains(
            '==> testing admin.com', $output
        );
        $this->assertContains(
            'Done!', $output
        );
    }

    public function testValidationErrors(): void
    {
        $url = 'test.com';
        $competitors = 'test.com';

        $mQuestionHelper = Mockery::mock(QuestionHelper::class);
        $mQuestionHelper->expects('ask')
                        ->times(3)
                        ->andReturnValues([
                            $url,
                            $competitors,
                            ReportAdapterStaticFactory::getDefaultTypeString(),
                        ]);

        $mPerformBenchmarkService = Mockery::mock(PerformBenchmarkService::class);
        $mPerformBenchmarkService->expects('run')
                                 ->with([
                                     new Url($url, false),
                                 ]);

        $mCommandBus = Mockery::mock(CommandBus::class);
        $mCommandBus->expects('handle')->withAnyArgs();

        $commandTester = new CommandTester(new RunBenchmarkCommand(
            $mQuestionHelper,
            $mPerformBenchmarkService,
            $mCommandBus
        ));

        $this->expectException('RuntimeException');
        $commandTester->execute([], []);

        $output = $commandTester->getDisplay();

        $this->assertContains(
            'test.com is redundant URL, skipping.', $output
        );
    }
}
