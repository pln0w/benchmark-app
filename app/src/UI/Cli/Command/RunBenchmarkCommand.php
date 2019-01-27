<?php

namespace App\UI\Cli\Command;

use App\Domain\Benchmark\Command\PerformBenchmarkCommand;
use App\Domain\Benchmark\Service\PerformBenchmarkService;
use App\Domain\Report\Command\GenerateReportCommand;
use App\Domain\Report\Factory\ReportStaticFactory;
use App\Domain\Report\ValueObject\ReportData;
use App\Domain\Report\ValueObject\TextReport;
use App\Domain\Url\ValueObject\Url;
use League\Tactician\CommandBus;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class RunBenchmarkCommand extends Command
{
    private const DEFAULT_URL = 'google.com';
    private const DEFAULT_COMPETITORS_URLS = 'bing.com, ask.com';

    protected $commandName = 'app:run';
    protected $commandDesc = 'Run benchmark';

    private $helper;
    private $benchmarkService;
    private $commandBus;
    private $input;
    private $output;

    public function __construct(
        QuestionHelper $helper,
        PerformBenchmarkService $benchmarkService,
        CommandBus $commandBus
    ) {
        parent::__construct($this->commandName);

        $this->helper = $helper;
        $this->benchmarkService = $benchmarkService;
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this->setName($this->commandName)
             ->setDescription($this->commandDesc);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $url = $this->askForUrl();
        $competitors = $this->askForCompetitors($url);
        $reportType = $this->askForReportType();

        // treat as a single array to walk through all urls in single loop
        array_push($competitors, $url);

        $results = [];
        foreach ($competitors as $website) {
            $results[] = $this->benchmarkService->run($website);
        }

        $reportData = new ReportData($results);
        $reportType = ReportStaticFactory::getAvailableTypesFlip()[$reportType];

        $this->commandBus->handle(new GenerateReportCommand($reportData, $reportType));

        $this->output->writeln("\n<info>Done!</info>");
    }


    private function askForUrl(): Url
    {
        $content = '<question>Please enter the website URL</question> ';
        $content .= '<comment>[default: '.self::DEFAULT_URL.']: </comment>';

        $answer = $this->helper->ask(
            $this->input,
            $this->output,
            new Question($content, self::DEFAULT_URL)
        );

        return new Url($answer, false);
    }


    private function askForCompetitors(Url $website): array
    {
        $content = '<question>Please enter the competitors URLs</question> ';
        $content .= '<comment>(comma separated) [default: '.self::DEFAULT_COMPETITORS_URLS.']: </comment>';

        $answer = $this->helper->ask(
            $this->input,
            $this->output,
            new Question($content, self::DEFAULT_COMPETITORS_URLS)
        );

        $competitors = explode(',', $answer);

        $urls = [];
        foreach ($competitors as $competitor) {
            $url = new Url(trim($competitor), true);
            if (!in_array($url, $urls, true) && !$url->equal($website)) {
                $urls[] = $url;
            } else {
                $this->output->writeln('<error>'.$url->getUrl().' is redundant URL, skipping.</error>');
            }
        }

        if (0 === count($urls)) {
            throw new RuntimeException('No valid URLs to perform benchmark.');
        }

        return $urls;
    }


    private function askForReportType(): string
    {
        $content = '<question>Select report type</question>';
        $content .= '<comment>[default: '.ReportStaticFactory::getDefaultType().']</comment>';

        return $this->helper->ask(
            $this->input,
            $this->output,
            new ChoiceQuestion(
                $content,
                ReportStaticFactory::getAvailableTypes(),
                ReportStaticFactory::getDefaultType()
            )
        );
    }
}
