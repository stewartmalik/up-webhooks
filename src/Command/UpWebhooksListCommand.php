<?php

declare(strict_types=1);

namespace App\Command;

use App\Up\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpWebhooksListCommand extends Command
{
    protected static $defaultName = 'up:webhooks:list';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;

        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->setDescription('Retrieve a list of configured webhooks')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $webhooks = $this->client->listWebhooks();

        $io->table(['id', 'created_at', 'url', 'description'], array_map(function($webhook) {
            return [
                $webhook['id'],
                $webhook['attributes']['createdAt'],
                $webhook['attributes']['url'],
                $webhook['attributes']['description']
            ];
        }, $webhooks['data']));

        return Command::SUCCESS;
    }
}
