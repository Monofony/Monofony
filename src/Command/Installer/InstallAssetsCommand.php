<?php

namespace App\Command\Installer;

use App\Command\Helper\EnsureDirectoryExistsAndIsWritable;
use App\Command\Helper\RunCommands;
use App\Installer\Checker\CommandDirectoryChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallAssetsCommand extends Command
{
    const WEB_ASSETS_DIRECTORY = 'public/assets/';
    const WEB_BUNDLES_DIRECTORY = 'public/bundles/';

    use EnsureDirectoryExistsAndIsWritable {
        EnsureDirectoryExistsAndIsWritable::__construct as private initializeEnsureDirectoryExistsAndIsWritable;
    }
    use RunCommands {
        RunCommands::__construct as private initializeRunCommands;
    }

    /**
     * @var CommandDirectoryChecker
     */
    private $commandDirectoryChecker;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var string
     */
    private $environment;

    /**
     * @param CommandDirectoryChecker $commandDirectoryChecker
     * @param EntityManagerInterface  $entityManager
     * @param string                  $environment
     */
    public function __construct(CommandDirectoryChecker $commandDirectoryChecker, EntityManagerInterface $entityManager, string $environment)
    {
        $this->commandDirectoryChecker = $commandDirectoryChecker;
        $this->entityManager = $entityManager;
        $this->environment = $environment;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->commandExecutor = new CommandExecutor($input, $output, $this->getApplication());

        $this->initializeEnsureDirectoryExistsAndIsWritable($this->commandDirectoryChecker, $this->getName());

        $this->initializeRunCommands($this->commandExecutor, $this->entityManager);
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
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Installing AppName assets for environment <info>%s</info>.', $this->environment));

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
