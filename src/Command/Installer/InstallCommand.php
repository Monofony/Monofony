<?php

namespace App\Command\Installer;

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
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Installing AppName...</info>');
        $output->writeln($this->getLogo());

        $this->ensureDirectoryExistsAndIsWritable($this->getContainer()->getParameter('kernel.cache_dir'), $output);

        $errored = false;
        foreach ($this->commands as $step => $command) {
            try {
                $output->writeln(sprintf('<comment>Step %d of %d.</comment> <info>%s</info>', $step + 1, count($this->commands), $command['message']));
                $this->commandExecutor->runCommand('app:install:'.$command['command'], [], $output);
                $output->writeln('');
            } catch (RuntimeException $exception) {
                $errored = true;
            }
        }

        $output->writeln($this->getProperFinalMessage($errored));
        $output->writeln('You can now open your website at the following path under the website root.');
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
