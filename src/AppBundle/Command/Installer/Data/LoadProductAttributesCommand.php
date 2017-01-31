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

use AppBundle\AttributeType\DpeAttributeType;
use AppBundle\AttributeType\GesAttributeType;
use AppBundle\AttributeType\HeatingTypeAttributeType;
use AppBundle\AttributeType\MoneyAttributeType;
use AppBundle\Entity\AttributeValueInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use spec\Sylius\Bundle\AttributeBundle\Form\Type\AttributeType\CheckboxAttributeTypeSpec;
use Sylius\Component\Attribute\AttributeType\CheckboxAttributeType;
use Sylius\Component\Attribute\AttributeType\DateAttributeType;
use Sylius\Component\Attribute\AttributeType\IntegerAttributeType;
use Sylius\Component\Attribute\AttributeType\TextAttributeType;
use Sylius\Component\Attribute\Factory\AttributeFactory;
use Sylius\Component\Attribute\Model\AttributeInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class LoadProductAttributesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:product-attributes:load')
            ->setDescription('Load all product attributes.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all product attributes.
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getAttributes() as $data) {
            $output->writeln(sprintf("Loading attribute with <info>%s</info> code", $data['code']));
            $attribute = $this->createOrReplaceAttribute($data);
            $this->getManager()->persist($attribute);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return AttributeInterface
     */
    protected function createOrReplaceAttribute(array $data)
    {
        /** @var AttributeInterface $attribute */
        $attribute = $this->getRepository()->findOneBy(array('code' => $data['code']));

        if (null === $attribute) {
            $attribute = $this->getFactory()->createTyped($data['type']);
        }

        $attribute->setCode($data['code']);
        $attribute->setName($data['name']);

        return $attribute;
    }

    /**
     * @return array
     */
    protected function getAttributes()
    {
        return [
            [
                'code' => AttributeValueInterface::CODE_ANNUAL_CHARGES,
                'name' => 'Charges annuelles',
                'type' => MoneyAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_BALCONY,
                'name' => 'Balcon',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_CELLAR,
                'name' => 'Cave',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_CHIMNEY,
                'name' => 'Cheminée',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_DISTRICT,
                'name' => 'Quartier',
                'type' => TextAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_DPE,
                'name' => 'DPE',
                'type' => DpeAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_ELEVATOR,
                'name' => 'Ascenseur',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_GARAGE,
                'name' => 'Garage',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_GARDEN,
                'name' => 'Jardin',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_GES,
                'name' => 'GES',
                'type' => GesAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_FLOOR,
                'name' => 'Étage',
                'type' => TextAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_HEATING_SYSTEM,
                'name' => 'Nature de chauffage',
                'type' => TextAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_HEATING_TYPE,
                'name' => 'Type de chauffage',
                'type' => HeatingTypeAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_INDOOR_PARKING,
                'name' => 'Parking intérieur',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_LIVING_AREA,
                'name' => 'Surface habitable',
                'type' => IntegerAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_LOT_NUMBER,
                'name' => 'N° de lot présenté',
                'type' => IntegerAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_LOT_COUNT,
                'name' => 'Nombre de lots',
                'type' => IntegerAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_MONTHLY_CHARGES,
                'name' => 'Charges mensuelles',
                'type' => MoneyAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_OUTDOOR_PARKING,
                'name' => 'Parking extérieur',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_RENT,
                'name' => 'Loyer',
                'type' => MoneyAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_ROOM_COUNT,
                'name' => 'Nombre de pièces',
                'type' => IntegerAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_SALE_OF_A_CONDOMINIUM,
                'name' => 'Vente en copropriété',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_SELLING_PRICE,
                'name' => 'Prix de vente',
                'type' => MoneyAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_SPECIAL_OFFER_TO_TENANTS,
                'name' => 'Offres réservées aux locataires d\'Alcéane',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_SPECIAL_OFFER_TO_TENANTS_END_AT,
                'name' => 'Offres réservées aux locataires d\'Alcéane jusq\'au',
                'type' => DateAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_TERRACE,
                'name' => 'Terrasse',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => 'gard',
                'name' => 'Gardien',
                'type' => TextAttributeType::TYPE,
            ],
            [
                'code' => 'bathroom',
                'name' => 'Salle de bain',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => 'accessibility',
                'name' => 'Accessibilité',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_FEES,
                'name' => 'Honoraires',
                'type' => CheckboxAttributeType::TYPE,
            ],
            [
                'code' => AttributeValueInterface::CODE_ONGOING_PROCEEDING,
                'name' => 'Procédure en cours',
                'type' => CheckboxAttributeType::TYPE,
            ],
        ];
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('sylius.manager.product_attribute');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('sylius.repository.product_attribute');
    }

    /**
     * @return AttributeFactory
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('sylius.factory.product_attribute');
    }
}