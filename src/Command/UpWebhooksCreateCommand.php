<?php

namespace App\Command;

use App\Up\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpWebhooksCreateCommand extends Command
{
    protected static $defaultName = 'up:webhooks:create';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;

        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a new webhook with a given URL')
            ->addArgument('url',
                InputArgument::REQUIRED,
                'The URL that this webhook should post events to. This must be a valid HTTP or HTTPS URL that does not exceed 300 characters in length.')
            ->addArgument('description',
                InputArgument::OPTIONAL,
                'An optional description for this webhook, up to 64 characters in length.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $createdWebhook = $this->client->createWebhook($input->getArgument('url'), $input->getArgument('description'));

        $io->success(sprintf("Created webhook: %s with secretKey: %s",
            $createdWebhook['data']['id'],
            $createdWebhook['data']['attributes']['secretKey']
        ));

        return Command::SUCCESS;
    }
}
