<?php

/*
 * This file is part of monofony.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Command\Helper;

use App\Command\Installer\CommandExecutor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

final class CommandsRunner
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ProgressBarCreator */
    private $progressBarCreator;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProgressBarCreator $progressBarCreator
    ) {
        $this->entityManager = $entityManager;
        $this->progressBarCreator = $progressBarCreator;
    }

    /**
     * @throws \Exception
     */
    public function run(array $commands, InputInterface $input, OutputInterface $output, Application $application, bool $displayProgress = true): void
    {
        $progress = $this->progressBarCreator->create($displayProgress ? $output : new NullOutput(), count($commands));
        $commandExecutor = new CommandExecutor($input, $output, $application);

        foreach ($commands as $key => $value) {
            if (is_string($key)) {
                $command = $key;
                $parameters = $value;
            } else {
                $command = $value;
                $parameters = [];
            }

            $commandExecutor->runCommand($command, $parameters);

            // PDO does not always close the connection after Doctrine commands.
            // See https://github.com/symfony/symfony/issues/11750.
            $this->entityManager->getConnection()->close();

            $progress->advance();
        }

        $progress->finish();
    }
}
