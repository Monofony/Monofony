<?php

namespace AppBundle\Command\Installer;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Corentin Nicole <corentin@mobizel.com>
 */
class InstallFixturesCommand extends AbstractInstallCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:install:fixtures')
            ->setDescription('Installs all AppName fixtures.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> comman installs AppName fixtures.
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Installing AppName fixtures for environment <info>%s</info>.', $this->getEnvironment()));

        $commands = [
            'sylius:fixtures:load',
        ];

        $this->runCommands($commands, $output);
    }
}
