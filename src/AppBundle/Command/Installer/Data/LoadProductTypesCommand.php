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
use Sylius\Component\Resource\Factory\Factory;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class LoadProductTypesCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('app:product-types:load')
            ->setDescription('Load types of products')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command load all types of products.
EOT
            );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        /** @var TaxonInterface $rootTaxon */
        $rootTaxon = $this->getRepository()->findOneBy(['code' => Taxon::CODE_TYPE]);

        foreach ($this->getTaxons() as $data) {
            $output->writeln(sprintf("Loading <comment>%s</comment> taxon", $data['name']));

            $taxon = $this->createOrReplaceTaxon($data, $rootTaxon);
            $this->getManager()->persist($taxon);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return TaxonInterface
     */
    protected function createOrReplaceTaxon(array $data, $rootTaxon)
    {
        /** @var TaxonInterface $taxon */
        $taxon = $this->getRepository()->findOneBy(['code' => $data['code']]);

        if (null === $taxon) {
            $taxon = $this->getFactory()->createNew();
        }

        $taxon->setParent($rootTaxon);
        $taxon->setCode($data['code']);
        $taxon->setName($data['name']);

        return $taxon;
    }

    /**
     * @return array
     */
    protected function getTaxons()
    {
        return [
            [
                'code' => Taxon::CODE_RENT_OFFER,
                'name' => 'Locations',
            ],
            [
                'code' => Taxon::CODE_SELL_OFFER,
                'name' => 'Ventes',
            ],
        ];
    }

    /**
     * @return Factory
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
