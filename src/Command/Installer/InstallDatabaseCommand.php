<?php

namespace App\Command\Installer;

use App\Command\Helper\RunCommands;
use App\Installer\Provider\DatabaseSetupCommandsProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallDatabaseCommand extends Command
{
    use RunCommands {
        __construct as private initializeRunCommands;
    }

    /**
     * @var DatabaseSetupCommandsProviderInterface
     */
    private $databaseSetupCommandsProvider;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var CommandExecutor
     */
    private $commandExecutor;

    /**
     * @param DatabaseSetupCommandsProviderInterface $databaseSetupCommandsProvider
     * @param EntityManagerInterface                 $entityManager
     * @param string                                 $environment
     */
    public function __construct(
        DatabaseSetupCommandsProviderInterface $databaseSetupCommandsProvider,
        EntityManagerInterface $entityManager,
        string $environment
    ) {
        $this->databaseSetupCommandsProvider = $databaseSetupCommandsProvider;
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
        $this->initializeRunCommands($this->commandExecutor, $this->entityManager);
    }

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
        $output->writeln(sprintf('Creating AppName database for environment <info>%s</info>.', $this->environment));

        $commands = $this->databaseSetupCommandsProvider->getCommands($input, $output, $this->getHelper('question'));

        $this->runCommands($commands, $output);
        $output->writeln('');

        $this->commandExecutor->runCommand('app:install:sample-data', [], $output);
    }
}
