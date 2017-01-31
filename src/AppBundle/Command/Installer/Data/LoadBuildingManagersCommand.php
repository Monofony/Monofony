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

use AppBundle\Entity\Address;
use AppBundle\Entity\BuildingManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Laurent Baey <lbaey@mobizel.com>
 */
class LoadBuildingManagersCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:building-managers:load')
            ->setDescription('Load all building managers.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all building managers.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getBuildingManagers() as $data) {
            $output->writeln(sprintf("Loading building manager with <info>%s</info> code", $data['code']));
            $attribute = $this->createOrReplaceBuildingManager($data);
            $this->getManager()->persist($attribute);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return BuildingManager
     */
    protected function createOrReplaceBuildingManager(array $data)
    {
        /** @var BuildingManager $buildingManager */
        $buildingManager = $this->getRepository()->findOneBy(array('code' => $data['code']));

        if (null === $buildingManager) {
            $buildingManager = $this->getFactory()->createNew();
        }

        $buildingManager->setCode($data['code']);
        $buildingManager->setLastName($data['last_name']);
        $buildingManager->setFirstName($data['first_name']);
        $buildingManager->setPhoneNumber($data['phone']);
        $buildingManager->setEmail($data['email']);
        $buildingManager->getAddress()->setStreet($data['address']['street']);
        $buildingManager->getAddress()->setPostcode($data['address']['postcode']);
        $buildingManager->getAddress()->setCity($data['address']['city']);

        return $buildingManager;
    }

    /**
     * @return array
     */
    protected function getBuildingManagers()
    {
        $buildingManagers = [];

        $buildingManagers[] = [
            'code' => '17529',
            'last_name' => 'PICARD',
            'first_name' => 'LEA',
            'phone' => '0235484937',
            'email' => 'l.picard@alceane.fr',
            'address' => [
                'street' => '122 RUE DE LA CAVEE VERTE',
                'postcode' => '76600',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '17601',
            'last_name' => 'GUEYE',
            'first_name' => 'TOURADOU',
            'phone' => '0235453256',
            'email' => 't.gueye@alceane.fr',
            'address' => [
                'street' => '45 ALLEE EUGENE LABICHE',
                'postcode' => '76620',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '17655',
            'last_name' => 'MOLLING',
            'first_name' => 'MARIE-CLAUDE',
            'phone' => '0235483630',
            'email' => 'm.molling@alceane.fr',
            'address' => [
                'street' => '1 RUE JEAN COCTEAU',
                'postcode' => '76620',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '17678',
            'last_name' => 'KHEDIMI',
            'first_name' => 'GUILLAUME',
            'phone' => '0235443780',
            'email' => 'g.khedimi@alceane.fr',
            'address' => [
                'street' => '33 RUE MAURICE GENEVOIX',
                'postcode' => '76620',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '17711',
            'last_name' => 'TURQUETILLE',
            'first_name' => 'CINDY',
            'phone' => '0235482178',
            'email' => 'c.turquetille@alceane.fr',
            'address' => [
                'street' => '58 RUE CHERUBINI',
                'postcode' => '76620',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '17747',
            'last_name' => 'BAZIRE',
            'first_name' => 'SARAH',
            'phone' => '0235213532',
            'email' => null,
            'address' => [
                'street' => '50 RUE HENRI CAYEUX',
                'postcode' => '76620',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '17757',
            'last_name' => 'CHARLES',
            'first_name' => 'FABIENNE',
            'phone' => '0235452735',
            'email' => null,
            'address' => [
                'street' => '171 RUE DU CT ABADIE',
                'postcode' => '76600',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '17797',
            'last_name' => 'CHETIOUI',
            'first_name' => 'BEKNRI',
            'phone' => '0232853096',
            'email' => 'b.chetioui@alceane.fr',
            'address' => [
                'street' => '444 AVENUE DU BOIS AU COQ',
                'postcode' => '76080',
                'city' => 'LE HAVRE CEDEX'
            ]
        ];
        $buildingManagers[] = [
            'code' => '17957',
            'last_name' => 'DELAMARE',
            'first_name' => 'ANTOINETTE',
            'phone' => '0235452947',
            'email' => null,
            'address' => [
                'street' => '18 ALLE EUGENE VARLIN',
                'postcode' => '76620',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '17981',
            'last_name' => 'PICARD',
            'first_name' => 'YANIS',
            'phone' => '0235244715',
            'email' => 'y.picard@alceane.fr',
            'address' => [
                'street' => '17 PASSAGE DUBOIS',
                'postcode' => '76600',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '18022',
            'last_name' => 'QUENEHEN',
            'first_name' => 'LUDOVIC',
            'phone' => '0235543935',
            'email' => 'l.quenehen@alceane.fr',
            'address' => [
                'street' => '71 RUE BIGNE A FOSSE',
                'postcode' => '76620',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '18023',
            'last_name' => 'BEAUFILS',
            'first_name' => 'THOMAS',
            'phone' => '0235473066',
            'email' => 't.beaufils@alceane.fr',
            'address' => [
                'street' => '60 RUE ELSA TRIOLET',
                'postcode' => '76600',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '18024',
            'last_name' => 'KERBORIOU',
            'first_name' => 'KÉVIN',
            'phone' => '0235493429',
            'email' => 'k.kerboriou@alceane.fr',
            'address' => [
                'street' => '8 AVENUE VLADIMIR KOMAROV',
                'postcode' => '76610',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '18025',
            'last_name' => 'BLANCHARD',
            'first_name' => 'ALICIA',
            'phone' => '0235452174',
            'email' => 'a.blanchard@alceane.fr',
            'address' => [
                'street' => '150 RUE DES SAULES',
                'postcode' => '76620',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '18028',
            'last_name' => 'CONSEIL',
            'first_name' => 'FRANCOIS',
            'phone' => '0235473449',
            'email' => 'f.conseil@alceane.fr',
            'address' => [
                'street' => '5 BIS ROUTE D\'ORCHER',
                'postcode' => '76700',
                'city' => 'GONFREVILLE L\'ORCHER'
            ]
        ];
        $buildingManagers[] = [
            'code' => '101086',
            'last_name' => 'BAUDUIN',
            'first_name' => 'SANDRINE',
            'phone' => '0235480040',
            'email' => 's.bauduin@alceane.fr',
            'address' => [
                'street' => '16 RUE CHARLES ROMME',
                'postcode' => '76610',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '103202',
            'last_name' => 'DRAGON',
            'first_name' => 'CHRISTINE',
            'phone' => '0235470969',
            'email' => 'c.dragon@alceane.fr',
            'address' => [
                'street' => '45 RUE LEO DELIBES',
                'postcode' => '76610',
                'city' => 'LE HAVRE'
            ]
        ];
        $buildingManagers[] = [
            'code' => '133806',
            'last_name' => 'RIQUOIR',
            'first_name' => 'MARIE-PIERRE',
            'phone' => '0235492543',
            'email' => 'm.riquoir@alceane.fr',
            'address' => [
                'street' => '9 RUE LOUISE MICHEL',
                'postcode' => '76610',
                'city' => 'LE HAVRE'
            ]
        ];

        return $buildingManagers;
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.building_manager');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('app.repository.building_manager');
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('app.factory.building_manager');
    }
}
