<?php
declare(strict_types=1);

namespace App\Infrastructure\Notification\Email\Adapter;

use App\Infrastructure\Notification\Email\MailerInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PhpMailer implements MailerInterface
{
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function send(string $from, array $recipients, string $subject, string $body): void
    {
        // this is mock

        $this->output->writeln(sprintf('%s', $body.PHP_EOL));
        $this->output->writeln(sprintf('%s', 'Email sent via PhpMailer.'.PHP_EOL));
    }
}
