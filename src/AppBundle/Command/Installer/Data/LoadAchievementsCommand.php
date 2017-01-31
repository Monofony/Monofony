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

use AppBundle\Entity\Achievement;
use AppBundle\Entity\Magazine;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class LoadAchievementsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:achievements:load')
            ->setDescription('Load all achievements.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all achievements.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getMagazines() as $data) {
            $output->writeln(sprintf("Loading achievement with <info>%s</info> title", $data['title']));
            $attribute = $this->createOrReplaceMagazine($data);
            $this->getManager()->persist($attribute);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return Achievement
     */
    protected function createOrReplaceMagazine(array $data)
    {
        /** @var Achievement $achievement */
        $achievement = $this->getRepository()->findOneBy(array('title' => $data['title']));

        if (null === $achievement) {
            $achievement = $this->getFactory()->createNew();
        }

        if (null === $achievement->getImage()) {
            $image = $this->getContainer()->get('app.factory.achievement_image')->createNew();
            $achievement->setImage($image);
        }

        $rootPath = $this->getContainer()->getParameter('kernel.root_dir') . '/../';

        $sourcePath = $rootPath . 'app/Resources/achievements/';
        $destinationPath = $rootPath . 'web/uploads/achievements/';

        $fileSystem = new Filesystem();
        $fileSystem->mkdir($destinationPath);

        $fileSystem->copy($sourcePath . 'images/' . $data['image'], $destinationPath . $data['image']);

        $achievement
            ->setTitle($data['title'])
            ->setDescription($data['description']);
        $achievement->getImage()->setPath($data['image'])->updateFileSize();

        return $achievement;
    }

    /**
     * @return array
     */
    protected function getMagazines()
    {
        return [
            [
                'title' => 'Hameau Vert - Mont-Gaillard',
                'description' => 'Construction de 33 pavillons et 12 appartements - 2014',
                'image' => '01_hameau_vert.jpg',
            ],
            [
                'title' => 'Paul Bouchez - Bléville',
                'description' => 'Réhabilitation en cours de la résidence - 91 appartements. Maître d\'oeuvre : Vous êtes ici Architectes.',
                'image' => '02_bouchez.jpg',
            ],
            // todo get 03_mare_rouge infos from alceane...
            [
                'title' => 'Les Briquetiers - Épouville',
                'description' => 'Acquisition / Démolition d\'un commerce puis construction de 5 appartements - 2015',
                'image' => '04_briquetiers.jpg',
            ],
            [
                'title' => 'Schooner et Caliari - Mare-Rouge',
                'description' => 'Construction en cours de pavillons et 23 appartements. Maître d\'oeuvre : GA Architecture. Prévision 2015.',
                'image' => '05_schooner.jpg',
            ],
            [
                'title' => 'Armand Barbès - Vallée Béreult',
                'description' => 'Réhabilitation environnementale de la résidence - 2014',
                'image' => '06_barbes.jpg',
            ],
            [
                'title' => 'Auguste Blanqui - Vallée Béreult',
                'description' => 'Réhabilitation en cours de la résidence - 78 appartements. Maître d\'oeuvre : Alcéane.4',
                'image' => '07_blanqui.jpg',
            ],
            [
                'title' => 'Massilia - Sanvic',
                'description' => 'Acquisition et réhabilitation de 5 appartements - 2015',
                'image' => '08_massilia.jpg',
            ],
        ];
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.achievement');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('app.repository.achievement');
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('app.factory.achievement');
    }
}
