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

use AppBundle\Entity\BusinessReview;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Corentin Nicole <corentin@mobizel.com>
 */
class LoadBusinessReviewsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:business-reviews:load')
            ->setDescription('Load all business reviews.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all business reviews.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getBusinessReview() as $data) {
            $output->writeln(sprintf("Loading business review with <info>%s</info> title", $data['title']));
            $businessReview = $this->createOrReplaceBusinessReview($data);
            $this->getManager()->persist($businessReview);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return BusinessReview
     */
    protected function createOrReplaceBusinessReview(array $data)
    {
        /** @var BusinessReview $businessReview */
        $businessReview = $this->getRepository()->findOneBy(array('title' => $data['title']));

        if (null === $businessReview) {
            $businessReview = $this->getFactory()->createNew();
        }

        if (null === $businessReview->getImage()) {
            $image = $this->getContainer()->get('app.factory.business_review_image')->createNew();
            $businessReview->setImage($image);
        }

        if (null === $businessReview->getFile()) {
            $file = $this->getContainer()->get('app.factory.business_review_file')->createNew();
            $businessReview->setFile($file);
        }

        $rootPath = $this->getContainer()->getParameter('kernel.root_dir') . '/../';

        $sourcePath = $rootPath . 'app/Resources/businessReviews/';
        $destinationPath = $rootPath . 'web/uploads/business-reviews/';

        $fileSystem = new Filesystem();
        $fileSystem->mkdir($destinationPath);

        $fileSystem->copy($sourcePath . 'images/' . $data['image'], $destinationPath . $data['image']);
        $fileSystem->copy($sourcePath . 'pdf/' . $data['file'], $destinationPath . $data['file']);

        $businessReview
            ->setReleaseNumber($data['release_number'])
            ->setTitle($data['title'])
            ->setDescription($data['description']);
        $businessReview->getImage()->setPath($data['image'])->updateFileSize();
        $businessReview->getFile()->setPath($data['file'])->updateFileSize();

        return $businessReview;
    }

    /**
     * @return array
     */
    protected function getBusinessReview()
    {
        return [
            [
                'release_number' => 2013,
                'title' => 'Le rapport d’activité de 2013 est sorti !',
                'description' => '<p>Rapport d’activité annuel</p>',
                'image' => 'business_review_2013.jpg',
                'file' => 'business_review_2013.pdf',
            ],
            [
                'release_number' => 2014,
                'title' => 'Le rapport d’activité de 2014 est sorti !',
                'description' => '<p>Rapport d’activité annuel</p>',
                'image' => 'business_review_2014.jpg',
                'file' => 'business_review_2014.pdf',
            ],
            [
                'release_number' => 2015,
                'title' => 'Le rapport d’activité de 2015 est sorti !',
                'description' => '<p>Rapport d’activité annuel</p>',
                'image' => 'business_review_2015.jpg',
                'file' => 'business_review_2015.pdf',
            ],

        ];
    }

    /**
     * @return EntityManager|object
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.business_review');
    }

    /**
     * @return EntityRepository|object
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('app.repository.business_review');
    }

    /**
     * @return FactoryInterface|object
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('app.factory.business_review');
    }
}
