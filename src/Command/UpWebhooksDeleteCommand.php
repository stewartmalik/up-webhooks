<?php

declare(strict_types=1);

namespace App\Command;

use App\Up\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpWebhooksDeleteCommand extends Command
{
    protected static $defaultName = 'up:webhooks:delete';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;

        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->setDescription('Delete a specific webhook by providing its unique identifier')
            ->addArgument('id', InputArgument::REQUIRED, 'The unique identifier for the webhook.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id = $input->getArgument('id');

        $this->client->deleteWebhook($id);

        $io->success("Deleted webhook: $id");

        return Command::SUCCESS;
    }
}
