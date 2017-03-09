<?php

/*
 * This file is part of UnivNantes.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Command;

use AppBundle\Command\Installer\InstallCommand;
use AppBundle\Command\Installer\InstallDataCommand;
use AppBundle\Command\Installer\SetupCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class InstallerContext extends DefaultContext
{
    /**
     * @var array
     */
    private $inputChoices = [
        'e-mail' => 'test@email.com',
        'password' => 'pswd',
        'confirmation' => 'pswd',
    ];

    /**
     * @param string $name
     */
    private function iExecuteCommandWithInputChoices($name)
    {
        $this->questionHelper = $this->command->getHelper('question');
        $inputString = implode(PHP_EOL, $this->inputChoices);
        $this->questionHelper->setInputStream($this->getInputStream($inputString.PHP_EOL));

        try {
            $this->getTester()->execute(['command' => $name]);
        } catch (\Exception $e) {
        }
    }

    /**
     * @When /^I run Install setup command$/
     */
    public function iRunInstallSetupCommmandLine()
    {
        $this->application = new Application($this->kernel);
        $this->application->add(new SetupCommand());

        $this->command = $this->application->find('app:install:setup');
        $this->setTester(new CommandTester($this->command));

        $this->iExecuteCommandWithInputChoices('app:install:setup');
    }

    /**
     * @When /^I run Install data command$/
     */
    public function iRunInstallDataCommandLine()
    {
        $commandName = 'app:install:data';

        $this->application = new Application($this->kernel);
        $this->application->add(new InstallDataCommand());

        $this->command = $this->application->find($commandName);

        $this->setTester(new CommandTester($this->command));
        $this->getTester()->execute(['command' => $commandName]);
    }
}
