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

use AppBundle\Entity\AttributeValueInterface;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductImage;
use AppBundle\Entity\Taxon;
use AppBundle\Factory\ProductFactory;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Faker\Factory;
use Sylius\Bundle\TaxonomyBundle\Doctrine\ORM\TaxonRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class LoadProductsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:products:load')
            ->setDescription('Load all products.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all products.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getProducts() as $data) {
            $output->writeln(sprintf("Loading product with <info>%s</info> code", $data['code']));
            $attribute = $this->createOrReplaceProduct($data);
            $this->getManager()->persist($attribute);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return Product
     */
    protected function createOrReplaceProduct(array $data)
    {
        /** @var Product $product */
        $product = $this->getRepository()->findOneBy(array('code' => $data['code']));

        if (null === $product) {
            $product = $this->getFactory()->createTyped($data['type']);
        }

        $product->setCode($data['code']);
        $product->setName($data['name']);
        $product->setDescription($data['description']);
        $product->setCategory($this->getTaxonRepository()->findOneByPermalink($data['category']));

        foreach ($data['attributes'] as $code => $value) {
            $attributeValue = $product->getAttributeByCode($code);

            if (null === $attributeValue) {
                throw new NotFoundHttpException(sprintf('attribute with code %s is not found', $code));
            }

            $attributeValue->setValue($value);
        }

        if (isset($data['city'])) {
            $city = $this->getContainer()->get('app.repository.city')->findOneBy(['name' => $data['city']]);
            $product->setCity($city);
        }

        foreach($product->getImages() as $image) {
            $product->removeImage($image);
            $this->getManager()->remove($image);
        }

        $rootPath = $this->getContainer()->getParameter('kernel.root_dir') . '/../';
        $sourcePath = $rootPath . 'app/Resources/products/images/';
        $destinationPath = $rootPath . 'web/uploads/img/';

        $fileSystem = new Filesystem();
        $fileSystem->mkdir($destinationPath);

        foreach ($data['images'] as $path) {
            $productImage = new ProductImage();
            $productImage->setPath($path);
            $product->addImage($productImage);

            $fileSystem->copy($sourcePath . $path, $destinationPath . $path);
        }

        return $product;
    }

    /**
     * @return array
     */
    protected function getProducts()
    {
        return [
            [
                'name' => 'Appartement T3 Caucriauville',
                'code' => '380220610',
                'type' => ProductFactory::TYPE_RENT_OFFER,
                'category' => 'categories/appartements',
                'city' => 'Le Havre',
                'images' => [
                    '380220610-1.jpg',
                    '380220610-2.jpg',
                    '380220610-3.jpg',
                ],
                'attributes' => [
                    AttributeValueInterface::CODE_DISTRICT => 'Caucriauville',
                    AttributeValueInterface::CODE_RENT => 398.15,
                    AttributeValueInterface::CODE_MONTHLY_CHARGES => 188.12,
                    AttributeValueInterface::CODE_ROOM_COUNT => 3,
                    AttributeValueInterface::CODE_LIVING_AREA => 75,
                    AttributeValueInterface::CODE_FLOOR => 2,
                    AttributeValueInterface::CODE_HEATING_SYSTEM => 'Gaz',
                    AttributeValueInterface::CODE_HEATING_TYPE => 'collective',
                    AttributeValueInterface::CODE_ELEVATOR => true,
                ],
                'description' => "<p>En plein cœur du quartier de Caucriauville, Alcéane vous propose un appartement type 3 d’une surface de 75m2. Proche des commerces (supermarchés, commerces et services de proximité) ce logement est idéalement situé entre l’IUT du Havre, le Lycée Robert Schuman et le Collège Eugène Varlin.</p><p>Transports en commun :<br />Tramway Ligne B
<br />Bus : Lignes 1 et 9</p>",
            ],
            [
                'name' => 'Appartement T4 Bléville',
                'code' => '505020037',
                'type' => ProductFactory::TYPE_RENT_OFFER,
                'category' => 'categories/appartements',
                'city' => 'Le Havre',
                'images' => [
                    '505020037-1.jpg',
                ],
                'attributes' => [
                    AttributeValueInterface::CODE_DISTRICT => 'Bléville',
                    AttributeValueInterface::CODE_RENT => 236.48,
                    AttributeValueInterface::CODE_MONTHLY_CHARGES => 138.47,
                    AttributeValueInterface::CODE_ROOM_COUNT => 4,
                    AttributeValueInterface::CODE_LIVING_AREA => 58,
                    AttributeValueInterface::CODE_FLOOR => 3,
                    AttributeValueInterface::CODE_HEATING_SYSTEM => 'Gaz',
                    AttributeValueInterface::CODE_HEATING_TYPE => 'collective',
                ],
                'description' => "<p>Au cœur du quartier de Bléville, Alcéane vous propose un appartement comprenant 3 chambres d’une superficie de 58m2. Proche de nombreux commerces de proximité (boulangerie, boucherie, primeur etc.), le logement est desservi par les transports en commun (lignes de bus 5, 6 et 3). </p>",
            ],
            [
                'name' => 'Appartement T3 Bléville',
                'code' => '701050118',
                'type' => ProductFactory::TYPE_RENT_OFFER,
                'category' => 'categories/appartements',
                'city' => 'Le Havre',
                'images' => [
                    '701050118-1.jpg',
                ],
                'attributes' => [
                    AttributeValueInterface::CODE_DISTRICT => 'Caucriauville',
                    AttributeValueInterface::CODE_RENT => 397.62,
                    AttributeValueInterface::CODE_MONTHLY_CHARGES => 180.55,
                    AttributeValueInterface::CODE_ROOM_COUNT => 3,
                    AttributeValueInterface::CODE_LIVING_AREA => 75,
                    AttributeValueInterface::CODE_FLOOR => 11,
                    AttributeValueInterface::CODE_HEATING_SYSTEM => 'Gaz',
                    AttributeValueInterface::CODE_HEATING_TYPE => 'collective',
                ],
                'description' => "<p>Entre les quartiers Bléville et Sanvic, Alcéane vous propose un appartement comprenant 2 chambres d’une superficie de 57m2.</p><p>Transports en commun :<br />Ligne de bus 3 au pied de l’immeuble<br />Lignes de bus 4 et 5</p>",
            ],
            [
                'name' => 'Appartement T4 Bléville',
                'code' => '701060147',
                'type' => ProductFactory::TYPE_RENT_OFFER,
                'category' => 'categories/appartements',
                'city' => 'Le Havre',
                'images' => [
                    '701060147-1.jpg',
                ],
                'attributes' => [
                    AttributeValueInterface::CODE_DISTRICT => 'Bléville',
                    AttributeValueInterface::CODE_RENT => 288.93,
                    AttributeValueInterface::CODE_MONTHLY_CHARGES => 210.46,
                    AttributeValueInterface::CODE_ROOM_COUNT => 3,
                    AttributeValueInterface::CODE_LIVING_AREA => 66,
                    AttributeValueInterface::CODE_FLOOR => 3,
                    AttributeValueInterface::CODE_HEATING_SYSTEM => 'Gaz',
                    AttributeValueInterface::CODE_HEATING_TYPE => 'collective',
                ],
                'description' => "<p>Entre les quartiers Bléville et Sanvic, Alcéane vous propose un appartement comprenant 3 chambres d’une superficie de 66m2.</p><p>Transports en commun :<br />Ligne de bus 3 au pied de l’immeuble<br />Lignes de bus 4 et 5</p>",
            ],
            [
                'name' => 'Appartement T3 Caucriauville',
                'code' => '380150094A',
                'type' => ProductFactory::TYPE_RENT_OFFER,
                'category' => 'categories/appartements',
                'city' => 'Le Havre',
                'images' => [
                    '380150094A-1.jpg',
                    '380150094A-2.jpg',
                ],
                'attributes' => [
                    AttributeValueInterface::CODE_DISTRICT => 'Bléville',
                    AttributeValueInterface::CODE_RENT => 288.93,
                    AttributeValueInterface::CODE_MONTHLY_CHARGES => 210.46,
                    AttributeValueInterface::CODE_ROOM_COUNT => 3,
                    AttributeValueInterface::CODE_LIVING_AREA => 66,
                    AttributeValueInterface::CODE_FLOOR => 3,
                    AttributeValueInterface::CODE_HEATING_SYSTEM => 'Gaz',
                    AttributeValueInterface::CODE_HEATING_TYPE => 'collective',
                    AttributeValueInterface::CODE_ELEVATOR => true,
                ],
                'description' => "<p>Dans le quartier de Caucriauville, Alcéane vous propose un appartement type T3 d’une superficie de 75m2. Proche des commerces et des services de proximité, ce logement est situé au 11ème étage, avec ascenseur, disposant ainsi d’une vue dégagée sans vis-à-vis.</p><p>Transports en commun :<br />Ligne de bus 7 au pied de l’immeuble<br />Tramway Ligne B</p>",
            ],
        ];
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('sylius.manager.product');
    }

    /**
     * @return ProductFactory
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('sylius.repository.product');
    }

    /**
     * @return TaxonRepository
     */
    protected function getTaxonRepository()
    {
        return $this->getContainer()->get('sylius.repository.taxon');
    }

    /**
     * @return ProductFactory
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('sylius.factory.product');
    }
}
