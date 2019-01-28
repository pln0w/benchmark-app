<?php

namespace App\UI\Cli\Command;

use App\Domain\Benchmark\Service\PerformBenchmarkService;
use App\Domain\Report\Command\GenerateReportCommand;
use App\Domain\Report\Factory\GenerateReportAdapterStaticFactory;
use App\Domain\Report\ValueObject\ReportData;
use App\Domain\Url\ValueObject\Url;
use League\Tactician\CommandBus;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class RunBenchmarkCommand extends Command
{
    private const DEFAULT_URL = 'yahoo.com';
    private const DEFAULT_COMPETITORS_URLS = 'bing.com, google.com, ask.com, duckduckgo.com';

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

        $competitors[] = $url;

        $results = [];
        foreach ($competitors as $website) {

            $this->output->writeln('==> testing '.$website->getUrl());

            try {

                $results[] = $this->benchmarkService->run($website);

            } catch (RuntimeException $e) {
                $this->output->writeln('<error>'.$e->getMessage().'</error>');
                continue;
            }
        }

        $this->output->writeln("\n<info>Done!</info>");

        $this->commandBus->handle(new GenerateReportCommand(
            new ReportData($results),
            GenerateReportAdapterStaticFactory::getAvailableTypesFlip()[$reportType]
        ));
    }


    private function askForUrl(): Url
    {
        $content = "<comment>Enter the website you want to compare with other competitors.\n";
        $content .= 'default: '.self::DEFAULT_URL.'</comment>';
        $content .= "\n<question>Please enter the website URL: </question> ";

        $answer = $this->helper->ask(
            $this->input,
            $this->output,
            new Question(
                $content,
                self::DEFAULT_URL
            )
        );

        return new Url($answer, false);
    }


    private function askForCompetitors(Url $website): array
    {
        $content = "\n<comment>Enter competitors websites URLs separated by comma.\n";
        $content .= 'default: '.self::DEFAULT_COMPETITORS_URLS.'</comment>';
        $content .= "\n<question>Please enter the competitors URLs</question> ";

        $answer = $this->helper->ask(
            $this->input,
            $this->output,
            new Question(
                $content,
                self::DEFAULT_COMPETITORS_URLS
            )
        );

        $competitors = explode(',', $answer);

        $urls = [];
        foreach ($competitors as $competitor) {
            $url = new Url(trim($competitor), true);

            if (in_array($url, $urls, true) || $url->equal($website)) {
                $this->output->writeln('<error>'.$url->getUrl().' is redundant URL, skipping.</error>');
                continue;
            }

            $urls[] = $url;
        }

        if (0 === count($urls)) {
            throw new RuntimeException('No valid URLs to perform benchmark.');
        }

        return $urls;
    }


    private function askForReportType(): string
    {
        $content = "\n<comment>Select the way you want to receive the report.</comment>\n";
        $content .= '<question>Select report type</question>';

        return $this->helper->ask(
            $this->input,
            $this->output,
            new ChoiceQuestion(
                $content,
                GenerateReportAdapterStaticFactory::getAvailableTypes(),
                GenerateReportAdapterStaticFactory::getDefaultType()
            )
        );
    }
}
