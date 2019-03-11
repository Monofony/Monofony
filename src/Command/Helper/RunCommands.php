<?php

/*
 * This file is part of monofony.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Command\Helper;

use App\Command\Installer\CommandExecutor;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

trait RunCommands
{
    use CreateProgressBar;

    /**
     * @var CommandExecutor
     */
    private $commandExecutor;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param CommandExecutor $commandExecutor
     * @param ObjectManager   $entityManager
     */
    public function __construct(CommandExecutor $commandExecutor, ObjectManager $entityManager)
    {
        $this->commandExecutor = $commandExecutor;
        $this->entityManager = $entityManager;
    }

    /**
     * @param array           $commands
     * @param OutputInterface $output
     * @param bool            $displayProgress
     *
     * @throws \Exception
     */
    protected function runCommands(array $commands, OutputInterface $output, bool $displayProgress = true): void
    {
        $progress = $this->createProgressBar($displayProgress ? $output : new NullOutput(), count($commands));

        foreach ($commands as $key => $value) {
            if (is_string($key)) {
                $command = $key;
                $parameters = $value;
            } else {
                $command = $value;
                $parameters = [];
            }

            $this->commandExecutor->runCommand($command, $parameters);

            // PDO does not always close the connection after Doctrine commands.
            // See https://github.com/symfony/symfony/issues/11750.
            $this->entityManager->getConnection()->close();

            $progress->advance();
        }

        $progress->finish();
    }
}
