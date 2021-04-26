<?php

declare(strict_types=1);

namespace App\Command\Installer;

use App\Command\Helper\DirectoryChecker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Exception\RuntimeException;

class InstallCommand extends Command
{
    private DirectoryChecker $directoryChecker;
    private string $cacheDir;
    private ?CommandExecutor $commandExecutor = null;

    /**
     * @var string[][]
     *
     * @psalm-var array{0: array{command: string, message: string}, 1: array{command: string, message: string}, 2: array{command: string, message: string}}
     */
    private array $commands = [
        [
            'command' => 'database',
            'message' => 'Setting up the database.',
        ],
        [
            'command' => 'setup',
            'message' => 'Website configuration.',
        ],
        [
            'command' => 'assets',
            'message' => 'Installing assets.',
        ],
    ];

    public function __construct(DirectoryChecker $directoryChecker, string $cacheDir)
    {
        $this->directoryChecker = $directoryChecker;
        $this->cacheDir = $cacheDir;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:install')
            ->setDescription('Installs AppName in your preferred environment.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command installs AppName.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->commandExecutor = new CommandExecutor($input, $output, $this->getApplication());
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $outputStyle = new SymfonyStyle($input, $output);
        $outputStyle->writeln('<info>Installing AppName...</info>');
        $outputStyle->writeln($this->getLogo());

        $this->directoryChecker->ensureDirectoryExistsAndIsWritable($this->cacheDir, $output, $this->getName());

        $errored = false;
        foreach ($this->commands as $step => $command) {
            try {
                $outputStyle->newLine();
                $outputStyle->section(sprintf(
                    'Step %d of %d. <info>%s</info>',
                    $step + 1,
                    count($this->commands),
                    $command['message']
                ));
                $this->commandExecutor->runCommand('app:install:'.$command['command'], [], $output);
                $output->writeln('');
            } catch (RuntimeException $exception) {
                $errored = true;
            }
        }

        $output->writeln($this->getProperFinalMessage($errored));
        $output->writeln('You can now open your website at the following path under the website root.');

        return 0;
    }

    /**
     * @return string
     */
    private function getProperFinalMessage(bool $errored)
    {
        if ($errored) {
            return '<info>AppName has been installed, but some error occurred.</info>';
        }

        return '<info>AppName has been successfully installed.</info>';
    }

    /**
     * @return string
     */
    private function getLogo()
    {
        return '
        
$$\      $$\                                $$$$$$\                               
$$$\    $$$ |                              $$  __$$\                              
$$$$\  $$$$ | $$$$$$\  $$$$$$$\   $$$$$$\  $$ /  \__|$$$$$$\  $$$$$$$\  $$\   $$\ 
$$\$$\$$ $$ |$$  __$$\ $$  __$$\ $$  __$$\ $$$$\    $$  __$$\ $$  __$$\ $$ |  $$ |
$$ \$$$  $$ |$$ /  $$ |$$ |  $$ |$$ /  $$ |$$  _|   $$ /  $$ |$$ |  $$ |$$ |  $$ |
$$ |\$  /$$ |$$ |  $$ |$$ |  $$ |$$ |  $$ |$$ |     $$ |  $$ |$$ |  $$ |$$ |  $$ |
$$ | \_/ $$ |\$$$$$$  |$$ |  $$ |\$$$$$$  |$$ |     \$$$$$$  |$$ |  $$ |\$$$$$$$ |
\__|     \__| \______/ \__|  \__| \______/ \__|      \______/ \__|  \__| \____$$ |
                                                                        $$\   $$ |
                                                                        \$$$$$$  |
                                                                         \______/ 
                                                                         
        ';
    }
}
