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
class LoadMagazinesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:magazines:load')
            ->setDescription('Load all magazines.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all magazines.
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
            $output->writeln(sprintf("Loading magazine with <info>%s</info> title", $data['title']));
            $attribute = $this->createOrReplaceMagazine($data);
            $this->getManager()->persist($attribute);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return Magazine
     */
    protected function createOrReplaceMagazine(array $data)
    {
        /** @var Magazine $magazine */
        $magazine = $this->getRepository()->findOneBy(array('title' => $data['title']));

        if (null === $magazine) {
            $magazine = $this->getFactory()->createNew();
        }

        if (null === $magazine->getImage()) {
            $image = $this->getContainer()->get('app.factory.magazine_image')->createNew();
            $magazine->setImage($image);
        }

        if (null === $magazine->getFile()) {
            $file = $this->getContainer()->get('app.factory.magazine_file')->createNew();
            $magazine->setFile($file);
        }

        $rootPath = $this->getContainer()->getParameter('kernel.root_dir') . '/../';

        $sourcePath = $rootPath . 'app/Resources/magazines/';
        $destinationPath = $rootPath . 'web/uploads/home-magazines/';

        $fileSystem = new Filesystem();
        $fileSystem->mkdir($destinationPath);

        $fileSystem->copy($sourcePath . 'images/' . $data['image'], $destinationPath . $data['image']);
        $fileSystem->copy($sourcePath . 'pdf/' . $data['file'], $destinationPath . $data['file']);

        $magazine
            ->setReleaseNumber($data['release_number'])
            ->setTitle($data['title'])
            ->setDescription($data['description']);
        $magazine->getImage()->setPath($data['image'])->updateFileSize();
        $magazine->getFile()->setPath($data['file'])->updateFileSize();

        return $magazine;
    }

    /**
     * @return array
     */
    protected function getMagazines()
    {
        return [
            [
                'release_number' => 1,
                'title' => 'Le n°1 est sorti !',
                'description' => '<p>Au plus proche de vous ! Après un numéro estival placé sous le signe de l’évasion et de la beauté, Home magazine fait sa rentrée de septembre !</p>',
                'image' => 'home_n1.jpg',
                'file' => 'home_n1.pdf',
            ],
            [
                'release_number' => 2,
                'title' => 'Le n°2 est sorti !',
                'description' => '<p>Au plus proche de vous ! Après un numéro estival placé sous le signe de l’évasion et de la beauté, Home magazine fait sa rentrée de septembre !</p>',
                'image' => 'home_n2.jpg',
                'file' => 'home_n2.pdf',
            ],
            [
                'release_number' => 3,
                'title' => 'Le n°3 est sorti !',
                'description' => '<p>Au plus proche de vous ! Après un numéro estival placé sous le signe de l’évasion et de la beauté, Home magazine fait sa rentrée de septembre !</p>',
                'image' => 'home_n3.jpg',
                'file' => 'home_n3.pdf',
            ],
            [
                'release_number' => 4,
                'title' => 'Le n°4 est sorti !',
                'description' => '<p>Au plus proche de vous ! Après un numéro estival placé sous le signe de l’évasion et de la beauté, Home magazine fait sa rentrée de septembre !</p>',
                'image' => 'home_n4.jpg',
                'file' => 'home_n4.pdf',
            ],
            [
                'release_number' => 5,
                'title' => 'Le n°5 est sorti !',
                'description' => '<p>Au plus proche de vous ! Après un numéro estival placé sous le signe de l’évasion et de la beauté, Home magazine fait sa rentrée de septembre !</p>',
                'image' => 'home_n5.jpg',
                'file' => 'home_n5.pdf',
            ],
            [
                'release_number' => 6,
                'title' => 'Le n°6 est sorti !',
                'description' => '<p>Au plus proche de vous ! Après un numéro estival placé sous le signe de l’évasion et de la beauté, Home magazine fait sa rentrée de septembre !</p>',
                'image' => 'home_n6.jpg',
                'file' => 'home_n6.pdf',
            ],
            [
                'release_number' => 7,
                'title' => 'Le n°7 est sorti !',
                'description' => '<p>Au plus proche de vous ! Après un numéro estival placé sous le signe de l’évasion et de la beauté, Home magazine fait sa rentrée de septembre !</p>',
                'image' => 'home_n7.jpg',
                'file' => 'home_n7.pdf',
            ],
            [
                'release_number' => 8,
                'title' => 'Le n°8 est sorti !',
                'description' => '<p>Au plus proche de vous ! Après un numéro estival placé sous le signe de l’évasion et de la beauté, Home magazine fait sa rentrée de septembre !</p>',
                'image' => 'home_n8.jpg',
                'file' => 'home_n8.pdf',
            ],
            [
                'release_number' => 9,
                'title' => 'Le n°9 est sorti !',
                'description' => '<p>Au plus proche de vous ! Après un numéro estival placé sous le signe de l’évasion et de la beauté, Home magazine fait sa rentrée de septembre !</p>',
                'image' => 'home_n9.jpg',
                'file' => 'home_n9.pdf',
            ],
        ];
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.magazine');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('app.repository.magazine');
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('app.factory.magazine');
    }
}
