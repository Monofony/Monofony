<?php

/*
 * This file is part of UnivNantes.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Command;

use App\Command\Installer\InstallDatabaseCommand;
use App\Command\Installer\SetupCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

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
     * @Given I do not provide an email
     */
    public function iDoNotProvideEmail()
    {
        $this->inputChoices['e-mail'] = '';
    }

    /**
     * @Given I do not provide a correct email
     */
    public function iDoNotProvideCorrectEmail()
    {
        $this->inputChoices['e-mail'] = 'janusz';
    }

    /**
     * @Given I provide full administrator data
     */
    public function iProvideFullAdministratorData()
    {
        $this->inputChoices['e-mail'] = 'test@admin.com';
        $this->inputChoices['password'] = 'pswd1$';
        $this->inputChoices['confirmation'] = $this->inputChoices['password'];
    }

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
     * @When /^I run Install database command$/
     */
    public function iRunInstallDatabaseCommmandLine()
    {
        $this->application = new Application($this->kernel);
        $this->application->add(new InstallDatabaseCommand());

        $this->command = $this->application->find('app:install:database');
        $this->setTester(new CommandTester($this->command));

        $this->iExecuteCommandAndConfirm('app:install:database');
    }
}
