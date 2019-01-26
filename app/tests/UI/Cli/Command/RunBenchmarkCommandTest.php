<?php

namespace Tests\UI\Cli\Command;

use App\UI\Cli\Command\RunBenchmarkCommand;
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
        $competitors = 'example.com, admin.com';
        $reportType = 'text';

        $mQuestionHelper = Mockery::mock(QuestionHelper::class);
        $mQuestionHelper->expects('ask')->times(3)->withAnyArgs()->andReturnValues([$url, $competitors, $reportType]);

        $commandTester = new CommandTester(new RunBenchmarkCommand($mQuestionHelper));
        $commandTester->execute([], []);

        $output = $commandTester->getDisplay();

        $this->assertContains(
            "Running benchmark for $url ...", $output
        );
    }

    public function testValidationErrors(): void
    {
        $mQuestionHelper = Mockery::mock(QuestionHelper::class);
        $mQuestionHelper->expects('ask')->withAnyArgs()->andThrows('RuntimeException');

        $commandTester = new CommandTester(new RunBenchmarkCommand($mQuestionHelper));

        $this->expectException('RuntimeException');
        $commandTester->execute([], []);

        $output = $commandTester->getDisplay();

        $this->assertContains(
            'The url argument should be string', $output
        );

        $this->assertContains(
            'The competitors argument should be string', $output
        );
    }
}
