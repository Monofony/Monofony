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

use AppBundle\Entity\Taxon;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class LoadRootTaxonsCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('app:root-taxons:load')
            ->setDescription('Load root taxons');
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getRootTaxons() as $data) {
            $output->writeln(sprintf("Loading <comment>%s</comment> root taxon", $data['name']));

            $rootTaxon = $this->createOrReplaceRootTaxon($data);
            $this->getManager()->persist($rootTaxon);
        }

        $this->getManager()->flush();
        $output->writeln(sprintf("<info>%s root taxons successfully loaded</info>", count($this->getRootTaxons())));
    }

    /**
     * @param array $data
     *
     * @return TaxonInterface
     */
    protected function createOrReplaceRootTaxon(array $data)
    {
        /** @var TaxonInterface $rootTaxon */
        $rootTaxon = $this->getRepository()->findOneBy(['code' => $data['code']]);

        if (null === $rootTaxon) {
            $rootTaxon = $this->getFactory()->createNew();
        }

        $rootTaxon->setCode($data['code']);
        $rootTaxon->setName($data['name']);

        return $rootTaxon;
    }

    /**
     * @return array
     */
    protected function getRootTaxons()
    {
        return [
            [
                'code' => Taxon::CODE_CATEGORY,
                'name' => 'Catégories',
            ],
            [
                'code' => Taxon::CODE_TYPE,
                'name' => 'Types',
            ],
        ];
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('sylius.factory.taxon');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('sylius.repository.taxon');
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }
}
