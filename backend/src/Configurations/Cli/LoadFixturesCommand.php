<?php

declare(strict_types=1);

namespace App\Configurations\Cli;

use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LoadFixturesCommand extends Command
{
    private Connection $connection;
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->connection = $container->get(Connection::class);
    }
    protected function configure(): void
    {
        $this
            ->setName('fixtures:load')
            ->setDescription('Load fixtures');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<comment>Loading fixtures</comment>');
        $this->connection->createQueryBuilder()
            ->insert('authentication_users')
            ->values(
                [
                    'id' => ':id',
                    'email' => ':email',
                ]
            )
            ->setParameter('id', '018d980e-c8f8-7015-ba0f-a3edff3243df')
            ->setParameter('email', 'user@lexusalex.tech')
            ->executeQuery();
        $output->writeln('<info>Done!</info>');
        return 0;
    }
}
