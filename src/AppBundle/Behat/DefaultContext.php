<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Doctrine\Bundle\PHPCRBundle\Command\WorkspacePurgeCommand;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Loïc Frémont <lc.fremont@gmail.com>
 */
class DefaultContext extends DefaultApiContext
{
    /**
     * @var string
     */
    protected $applicationName = 'app';

    /**
     * @var Application
     */
    private $application;

    /**
     * @var CommandTester
     */
    private $tester;

    /**
     * @var ContainerAwareCommand
     */
    private $command;

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
     * @param string $resourceName
     * @param null|string $applicationName
     *
     * @return FactoryInterface
     */
    protected function getFactory($resourceName, $applicationName = null)
    {
        $applicationName = null === $applicationName ? $this->applicationName : $applicationName;

        /** @var FactoryInterface $factory */
        $factory = $this->getService($applicationName . '.factory.' . $resourceName);

        return $factory;
    }

    /**
     * @param string $type
     * @param array $criteria
     * @param null|string $applicationName
     *
     * @return object
     */
    protected function findOneBy($type, array $criteria, $applicationName = null)
    {
        $applicationName = null === $applicationName ? $this->applicationName : $applicationName;

        $resource = $this
            ->getRepository($type, $applicationName)
            ->findOneBy($criteria);

        if (null === $resource) {
            throw new \InvalidArgumentException(
                sprintf('%s for criteria "%s" was not found.', str_replace('_', ' ', ucfirst($type)), serialize($criteria))
            );
        }

        return $resource;
    }

    /**
     * @param string $resourceName
     * @param null|string $applicationName
     *
     * @return RepositoryInterface
     */
    protected function getRepository($resourceName, $applicationName = null)
    {
        $applicationName = null === $applicationName ? $this->applicationName : $applicationName;

        /** @var RepositoryInterface $repository */
        $repository = $this->getService($applicationName . '.repository.' . $resourceName);

        return $repository;
    }

    /**
     * @return ObjectManager
     */
    protected function getDocumentManager()
    {
        return $this->getService('doctrine_phpcr')->getManager();
    }
}