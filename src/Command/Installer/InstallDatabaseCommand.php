<?php

namespace App\Command\Installer;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallDatabaseCommand extends AbstractInstallCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:install:database')
            ->setDescription('Install AppName database.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates AppName database.
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Creating AppName database for environment <info>%s</info>.', $this->getEnvironment()));

        $commands = $this->get('sylius.commands_provider.database_setup')->getCommands($input, $output, $this->getHelper('question'));

        $this->runCommands($commands, $output);
        $output->writeln('');

        $this->commandExecutor->runCommand('app:install:sample-data', [], $output);
    }
}
