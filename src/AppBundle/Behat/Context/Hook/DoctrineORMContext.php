<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Context\Hook;

use AppBundle\Behat\DefaultContext;
use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
final class DoctrineORMContext extends DefaultContext
{
    /**
     * @BeforeScenario
     */
    public function purgeDatabase()
    {
        $this->getEntityManager()->getConnection()->getConfiguration()->setSQLLogger(null);
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
        $this->getEntityManager()->clear();
    }
}
