<?php

/*
 * This file is part of UnivNantes.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Context\Cli;

use App\Command\Installer\SetupCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;

class InstallerContext extends DefaultContext
{
    /**
     * @var SetupCommand
     */
    private $setupCommand;

    /**
     * @var array
     */
    private $inputChoices = [
        'e-mail' => 'test@email.com',
        'password' => 'pswd',
        'confirmation' => 'pswd',
    ];

    /**
     * @param KernelInterface $kernel
     * @param SetupCommand    $setupCommand
     */
    public function __construct(KernelInterface $kernel, SetupCommand $setupCommand)
    {
        $this->setupCommand = $setupCommand;

        parent::__construct($kernel);
    }

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
        $this->getTester()->setInputs($this->inputChoices);

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
        $this->application->add($this->setupCommand);

        $this->command = $this->application->find('app:install:setup');
        $this->setTester(new CommandTester($this->command));

        $this->iExecuteCommandWithInputChoices('app:install:setup');
    }

    /**
     * @param string $name
     */
    protected function iExecuteCommandAndConfirm($name)
    {
        $this->questionHelper = $this->command->getHelper('question');

        $this->getTester()->setInputs(['y', 'y']);

        try {
            $this->getTester()->execute(['command' => $name]);
        } catch (\Exception $e) {
        }
    }
}
