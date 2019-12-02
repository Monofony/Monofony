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

namespace App\Tests\Behat\Context\Cli;

use Behat\Behat\Context\Context;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Webmozart\Assert\Assert;

class MakefileContext implements Context
{
    /** @var Process */
    private $process;

    /** @var string */
    private $lastOutput;

    /**
     * @When I use default makefile commands
     */
    public function useDefaultMakeFileCommands()
    {
        $this->ensureMakeFileDirExist();
        $this->writeMakefileData(<<<EOM
include Makefile.dist

EOM
);
    }

    /**
     * @When I override makefile :commandName command with :firstData
     * @When I override makefile :commandName command with :firstdata and :secondData
     */
    public function overrideCommandWithData(string $commandName, ...$data)
    {
        $commandData = implode("\n\t", $data);

        $this->ensureMakeFileDirExist();
        $this->writeMakefileData(<<<EOM
include Makefile.dist

$commandName:
\t$commandData

EOM
        );
    }

    /**
     * @Then the command make :commandName should exist
     */
    public function commandExist(string $commandName): void
    {
        $this->dryRunCommand($commandName);
        Assert::true($this->process->isSuccessful());
    }

    /**
     * @Then it should execute :commandName
     */
    public function iShouldExecute(string $commandName)
    {
        Assert::contains($this->lastOutput, $commandName);
    }

    /**
     * @Then it should not execute :commandName
     */
    public function iShouldNotSee(string $commandName)
    {
        $this->dryRunCommand($commandName);
        Assert::notContains($this->lastOutput, $commandName);
    }

    private function dryRunCommand(string $command): void
    {
        $this->process = new Process([
            'make',
            '-n',
            $command,
            sprintf('--file=%s', $this->getMakeFilePathname()),
        ]);
        $this->process->run();
        $this->lastOutput = $this->process->getOutput();
    }

    private function getMakeFileDir(): string
    {
        return __DIR__.'/../../../../var';
    }

    private function getMakeFilePathname(): string
    {
        return sprintf('%s/Makefile', $this->getMakeFileDir());
    }

    private function ensureMakeFileDirExist(): void
    {
        $fileSystem = new Filesystem();
        $fileSystem->mkdir($this->getMakeFileDir());
    }

    private function writeMakefileData(string $data)
    {
        $this->ensureMakeFileDirExist();
        file_put_contents($this->getMakeFilePathname(), $data);
    }
}
