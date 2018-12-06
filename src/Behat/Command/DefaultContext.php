<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Command;

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class DefaultContext implements Context, KernelAwareContext
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @var CommandTester
     */
    protected static $sharedTester;

    /**
     * @var Command
     */
    protected $command;

    /**
     * @var QuestionHelper
     */
    protected $questionHelper;

    /**
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function setTester(CommandTester $tester)
    {
        static::$sharedTester = $tester;
    }

    /**
     * @return CommandTester
     */
    public function getTester()
    {
        return static::$sharedTester;
    }

    /**
     * @BeforeScenario
     */
    public function purgeDatabase(BeforeScenarioScope $scope)
    {
        /** @var EntityManager $em */
        $em = $this->getEntityManager();
        $stmt = $em
            ->getConnection()
            ->prepare('SET foreign_key_checks = 0;');
        $stmt->execute();
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
        $stmt = $em
            ->getConnection()
            ->prepare('SET foreign_key_checks = 1;');
        $stmt->execute();
    }

    /**
     * @return ObjectManager
     */
    protected function getEntityManager()
    {
        return $this->getService('doctrine')->getManager();
    }

    /**
     * @param string $id
     *
     * @return object
     */
    protected function getService($id)
    {
        return $this->getContainer()->get($id);
    }

    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }

    /**
     * @param string $input
     *
     * @return resource
     */
    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fwrite($stream, $input);
        rewind($stream);

        return $stream;
    }

    /**
     * @param string $name
     */
    protected function iExecuteCommandAndConfirm($name)
    {
        $this->questionHelper = $this->command->getHelper('question');
        $inputString = 'y'.PHP_EOL;
        $this->questionHelper->setInputStream($this->getInputStream($inputString));

        try {
            $this->getTester()->execute(['command' => $name]);
        } catch (\Exception $e) {
        }
    }
}
