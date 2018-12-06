<?php

namespace App\Command\Installer;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallAssetsCommand extends AbstractInstallCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:install:assets')
            ->setDescription('Installs all AppName assets.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command downloads and installs all AppName media assets.
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Installing AppName assets for environment <info>%s</info>.', $this->getEnvironment()));

        try {
            $this->ensureDirectoryExistsAndIsWritable(self::WEB_ASSETS_DIRECTORY, $output);
            $this->ensureDirectoryExistsAndIsWritable(self::WEB_BUNDLES_DIRECTORY, $output);
        } catch (\RuntimeException $exception) {
            return 1;
        }

        $commands = [
            'assets:install',
        ];

        $this->runCommands($commands, $output);
    }
}
