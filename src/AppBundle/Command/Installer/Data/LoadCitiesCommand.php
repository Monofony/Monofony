<?php

/*
 * This file is part of Alceane.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Command\Installer\Data;

use AppBundle\Entity\City;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class LoadCitiesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:cities:load')
            ->setDescription('Load all cities.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all cities.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getCities() as $name) {
            $output->writeln(sprintf("Loading city with <info>%s</info> name", $name));
            $attribute = $this->createOrReplaceCity($name);
            $this->getManager()->persist($attribute);
        }

        $this->getManager()->flush();
    }

    /**
     * @param string $name
     *
     * @return City
     */
    protected function createOrReplaceCity($name)
    {
        /** @var City $city */
        $city = $this->getRepository()->findOneBy(array('name' => $name));

        if (null === $city) {
            $city = $this->getFactory()->createNew();
        }

        $city->setName($name);

        return $city;
    }

    /**
     * @return array
     */
    protected function getCities()
    {
        return array(
            'Le Havre',
            'Criquetot l\'Esneval',
            'Epouville',
            'Etretat',
            'Fontaine la Mallet',
            'Gainneville',
            'Gonfreville l\'Orcher',
            'Harfleur',
            'Montivilliers',
            'Octeville-sur-Mer',
            'Saint Jouin Bruneval',
            'Sainte-Adresse',
            'Sandouville',
            'Yport',
        );
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.city');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('app.repository.city');
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('app.factory.city');
    }
}
