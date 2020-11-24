<?php

namespace App\Command;

use App\Up\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpPingCommand extends Command
{
    protected static $defaultName = 'up:ping';

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;

        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this
            ->setDescription('Make a basic ping request to the API')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $ping = $this->client->ping();

        $io->success(sprintf("Successfully pinged API via user ID: %s %s", $ping['meta']['id'], $ping['meta']['statusEmoji']));

        return Command::SUCCESS;
    }

}
