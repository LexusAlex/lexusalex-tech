<?php

declare(strict_types=1);

namespace App\Configurations\Cli;

use App\Authentication\Fixture\UserFixture;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class LoadFixturesCommand extends Command
{
    private ContainerInterface $container;
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
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

        $fixtures = [UserFixture::class];

        foreach ($fixtures as $fixture) {
            $this->container->get($fixture)->load();
        }
        $output->writeln('<info>Done!</info>');
        return 0;
    }
}
