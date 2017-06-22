<?php

namespace AppBundle\Command\Installer;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\RuntimeException;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class InstallCommand extends AbstractInstallCommand
{
    /**
     * @var array
     */
    private $commands = [
        [
            'command' => 'database',
            'message' => 'Setting up the database.',
        ],
        [
            'command' => 'assets',
            'message' => 'Installing assets.',
        ],
    ];

    /**
     * @var array
     */
    private $setupCommands = [
        [
            'command' => 'setup',
            'message' => 'Shop configuration.',
        ],
    ];

    /**
     * @var array
     */
    private $fixtureCommands = [
        [
            'command' => 'fixtures',
            'message' => 'Installing fixtures',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:install')
            ->addOption('mode', null,InputArgument::OPTIONAL, 'select install mode', 'setup')
            ->setDescription('Installs AppName in your preferred environment.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command installs AppName.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Installing AppName...</info>');
        $output->writeln('');

        $this->ensureDirectoryExistsAndIsWritable($this->getContainer()->getParameter('kernel.cache_dir'), $output);

        switch ($input->getOption('mode')) {
            case 'setup':
                $this->commands = array_merge($this->commands, $this->setupCommands);
                break;
            case 'fixture':
                $this->commands = array_merge($this->commands, $this->fixtureCommands);
                break;
            default:
                break;
        }

        $errored = false;

        foreach ($this->commands as $step => $command) {
            try {
                $output->writeln(sprintf('<comment>Step %d of %d.</comment> <info>%s</info>', $step + 1, count($this->commands), $command['message']));
                $this->commandExecutor->runCommand('app:install:' . $command['command'], [], $output);
                $output->writeln('');
            } catch (RuntimeException $exception) {
                $errored = true;
            }
        }


        $frontControllerPath = 'prod' === $this->getEnvironment() ? '/' : sprintf('/app_%s.php', $this->getEnvironment());

        $output->writeln($this->getProperFinalMessage($errored));
        $output->writeln(sprintf('You can now open your store at the following path under the website root: <info>%s.</info>', $frontControllerPath));
    }

    /**
     * @return string
     */
    private function getProperFinalMessage($errored)
    {
        if ($errored) {
            return '<info>AppName has been installed, but some error occurred.</info>';
        }

        return '<info>AppName has been successfully installed.</info>';
    }
}
