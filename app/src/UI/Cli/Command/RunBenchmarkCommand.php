<?php

namespace App\UI\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class RunBenchmarkCommand extends Command
{
    private const DEFAULT_URL = 'google.com';
    private const DEFAULT_COMPETITORS_URLS = 'bing.com, duckduckgo.com, ask.com';

    protected $commandName = 'app:run';
    protected $commandDesc = 'Run benchmark';

    private $helper;

    public function __construct(QuestionHelper $helper)
    {
        parent::__construct($this->commandName);
        $this->helper = $helper;
    }

    protected function configure(): void
    {
        $this->setName($this->commandName)
             ->setDescription($this->commandDesc);
    }

    private function getUrl(InputInterface $input, OutputInterface $output): string
    {
        $urlQuestion = (new Question(
            "\n<question>Please enter the URL of the website to benchmark:</question> ",
            self::DEFAULT_URL
        ))->setValidator(function ($answer) {
            if (is_numeric($answer)) {
                throw new \RuntimeException(
                    'The url argument should be string'
                );
            }

            return $answer;
        })->setMaxAttempts(2);

        return $this->helper->ask($input, $output, $urlQuestion);
    }

    private function getCompetitors(InputInterface $input, OutputInterface $output): string
    {
        $competitorsQuestion = (new Question(
            "\n<question>Please enter the URLs of the competitors websites to benchmark:</question> ",
            self::DEFAULT_COMPETITORS_URLS
        ))->setValidator(function ($answer) {
            if (is_numeric($answer)) {
                throw new \RuntimeException(
                    'The competitors argument should be string'
                );
            }

            return $answer;
        })->setMaxAttempts(2);

        return $this->helper->ask($input, $output, $competitorsQuestion);
    }

    private function getReportType(InputInterface $input, OutputInterface $output): string
    {
        /*
         * Open for modification in the future
         */
        $reportType = new ChoiceQuestion(
            "\n<question>Select report type:</question> ", ['text'], 'text'
        );

        return $this->helper->ask($input, $output, $reportType);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $this->getUrl($input, $output);
        $competitors = $this->getCompetitors($input, $output);
        $reportType = $this->getReportType($input, $output);

        $output->writeln("Running benchmark for $url ...");
    }
}
