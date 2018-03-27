<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command\Installer;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractInstallCommand extends ContainerAwareCommand
{
    const WEB_ASSETS_DIRECTORY = 'web/assets/';
    const WEB_BUNDLES_DIRECTORY = 'web/bundles/';
    const WEB_MEDIA_DIRECTORY = 'web/media/';
    const WEB_MEDIA_IMAGE_DIRECTORY = 'web/media/image/';

    /**
     * @var CommandExecutor
     */
    protected $commandExecutor;

    /**
     * {@inheritdoc}
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $application = $this->getApplication();
        $application->setCatchExceptions(false);

        $this->commandExecutor = new CommandExecutor($input, $output, $application);
    }

    /**
     * @param string $id
     *
     * @return object
     */
    protected function get($id)
    {
        return $this->getContainer()->get($id);
    }

    /**
     * @return string
     */
    protected function getEnvironment()
    {
        return $this->get('kernel')->getEnvironment();
    }

    /**
     * @return bool
     */
    protected function isDebug()
    {
        return $this->get('kernel')->isDebug();
    }

    /**
     * @param array $headers
     * @param array $rows
     * @param OutputInterface $output
     */
    protected function renderTable(array $headers, array $rows, OutputInterface $output)
    {
        $table = new Table($output);

        $table
            ->setHeaders($headers)
            ->setRows($rows)
            ->render()
        ;
    }

    /**
     * @param OutputInterface $output
     * @param int $length
     *
     * @return ProgressBar
     */
    protected function createProgressBar(OutputInterface $output, $length = 10)
    {
        ProgressBar::setFormatDefinition('custom', ' %current%/%max% [%bar%] %percent:3s%% <info>%command_name%</info>');

        $progress = new ProgressBar($output);
        $progress->setFormat('custom');
        $progress->setBarCharacter('<info>|</info>');
        $progress->setBarCharacter('<info>|</info>');
        $progress->setEmptyBarCharacter(' ');
        $progress->setProgressCharacter('|');

        return $progress;
    }

    /**
     * @param string $commandName
     *
     * @return \Closure
     */
    protected function getCommandDescriptionClosure($commandName)
    {
        return function() use ($commandName) {
            /** @var Command $command */
            $command = $this->getApplication()->find($commandName);

            return $command->getDescription();
        };
    }

    /**
     * @param array $commands
     * @param OutputInterface $output
     */
    protected function runCommands(array $commands, OutputInterface $output)
    {
        $length = count($commands);
        $progress = $this->createProgressBar($output, $length);
        $started = false;

        foreach ($commands as $key => $value) {
            if (is_string($key)) {
                $command = $key;
                $parameters = $value;
            } else {
                $command = $value;
                $parameters = [];
            }

            ProgressBar::setPlaceholderFormatterDefinition('command_name', $this->getCommandDescriptionClosure($command));

            if (!$started) {
                $progress->start($length);
                $started = true;
            } else {
                $progress->advance();
            }

            $this->commandExecutor->runCommand($command, $parameters);

            // PDO does not always close the connection after Doctrine commands.
            // See https://github.com/symfony/symfony/issues/11750.
            $this->get('doctrine')->getManager()->getConnection()->close();
        }

        $progress->finish();
    }

    /**
     * @param string $directory
     * @param OutputInterface $output
     */
    protected function ensureDirectoryExistsAndIsWritable($directory, OutputInterface $output)
    {
        $checker = $this->get('sylius.installer.checker.command_directory');
        $checker->setCommandName($this->getName());

        $checker->ensureDirectoryExists($directory, $output);
        $checker->ensureDirectoryIsWritable($directory, $output);
    }
}
