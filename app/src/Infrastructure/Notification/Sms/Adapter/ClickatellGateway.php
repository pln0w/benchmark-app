<?php
declare(strict_types=1);

namespace App\Infrastructure\Notification\Sms\Adapter;

use App\Infrastructure\Notification\Sms\SmsGatewayInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ClickatellGateway implements SmsGatewayInterface
{
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function send(array $recipients, string $body): void
    {
        // this is mock

        $this->output->writeln(sprintf('%s', $body.PHP_EOL));
        $this->output->writeln(sprintf('%s', 'SMS sent via Clickatell gateway.'.PHP_EOL));
    }
}
