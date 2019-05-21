<?php

namespace App\Command\Installer;

use App\Command\Helper\CommandsRunner;
use App\Command\Helper\DirectoryChecker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallAssetsCommand extends Command
{
    /**
     * @var DirectoryChecker
     */
    private $directoryChecker;
    /**
     * @var CommandsRunner
     */
    private $commandsRunner;
    /**
     * @var string
     */
    private $publicDir;
    /**
     * @var string
     */
    private $environment;

    public function __construct(
        DirectoryChecker $directoryChecker,
        CommandsRunner $commandsRunner,
        string $publicDir,
        string $environment
    ) {
        $this->directoryChecker = $directoryChecker;
        $this->commandsRunner = $commandsRunner;
        $this->publicDir = $publicDir;
        $this->environment = $environment;

        parent::__construct();
    }

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
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Installing AppName assets for environment <info>%s</info>.', $this->environment));

        try {
            $this->directoryChecker->ensureDirectoryExistsAndIsWritable($this->publicDir.'/assets/', $output, $this->getName());
            $this->directoryChecker->ensureDirectoryExistsAndIsWritable($this->publicDir.'/bundles/', $output, $this->getName());
        } catch (\RuntimeException $exception) {
            return 1;
        }

        $commands = [
            'assets:install',
        ];

        $this->commandsRunner->run($commands, $input, $output, $this->getApplication());
    }
}
