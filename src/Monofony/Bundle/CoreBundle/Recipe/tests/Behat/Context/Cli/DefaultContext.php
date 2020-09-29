<?php

namespace App\Tests\Behat\Context\Cli;

use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class DefaultContext implements Context
{
    protected $kernel;
    protected $application;
    protected static $sharedTester;
    protected $command;
    protected $questionHelper;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function setTester(CommandTester $tester): void
    {
        static::$sharedTester = $tester;
    }

    public function getTester(): CommandTester
    {
        return static::$sharedTester;
    }

    protected function getEntityManager(): ObjectManager
    {
        return $this->getService('doctrine')->getManager();
    }

    /**
     * @return object
     */
    protected function getService(string $id)
    {
        return $this->getContainer()->get($id);
    }

    protected function getContainer(): ContainerInterface
    {
        return $this->kernel->getContainer();
    }
}
