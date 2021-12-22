<?php

declare(strict_types=1);

namespace App\Command\Installer;

use App\Command\Helper\CommandsRunner;
use Doctrine\Bundle\FixturesBundle\Command\LoadDataFixturesDoctrineCommand;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

final class InstallSampleDataCommand extends Command
{
    protected static $defaultName = 'app:install:sample-data';

    public function __construct(
        private CommandsRunner $commandsRunner,
        private string $environment
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setDescription('Install sample data into AppName.')
            ->setHelp(
                <<<EOT
The <info>%command.name%</info> command loads the sample data for AppName.
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');

        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->newLine();
        $outputStyle->writeln(sprintf(
            'Loading sample data for environment <info>%s</info>.',
            $this->environment
        ));

        $outputStyle->writeln('<error>Warning! This action will erase your database.</error>');

        if (!$questionHelper->ask($input, $output, new ConfirmationQuestion('Continue? (y/N) ', false))) {
            $outputStyle->writeln('Cancelled loading sample data.');

            return 0;
        }

        $commands = [
            LoadDataFixturesDoctrineCommand::getDefaultName() => ['--no-interaction' => true],
        ];

        $this->commandsRunner->run($commands, $input, $output, $this->getApplication());
        $outputStyle->newLine(2);

        return 0;
    }
}
