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

use AppBundle\Document\ArticleDocument;
use AppBundle\Document\ImagineBlock;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Faker\Factory;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Cmf\Bundle\MediaBundle\Doctrine\Phpcr\Image;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class LoadArticleDocumentsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:article-documents:load')
            ->setDescription('Load all articles.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all articles.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getArticles() as $data) {
            $output->writeln(sprintf("Loading article with <info>%s</info> title", $data['title']));
            $article = $this->createOrReplaceArticle($data);
            $this->getManager()->persist($article);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return ArticleDocument
     */
    protected function createOrReplaceArticle(array $data)
    {
        /** @var ArticleDocument $articleDocument */
        $articleDocument = $this->getRepository()->findOneBy(array('title' => $data['title']));

        if (null === $articleDocument) {
            $articleDocument = $this->getFactory()->createNew();
        }

        $articleDocument->setTitle($data['title']);
        $articleDocument->setBody($data['body']);
        $articleDocument->setCategory($data['category']);

        $mainImage = $articleDocument->getMainImage();

        if (null === $mainImage) {
            /** @var ImagineBlock $mainImage */
            $mainImage = $this->getContainer()->get('app.factory.imagine_block')->createNew();
            $mainImage->setImage(new Image());

            $articleDocument
                ->setMainImage($mainImage);
        }

        $mainImage->getImage()->setFileContent(file_get_contents($data['main_image']));

        // TODO use a lifecycle event with a slugify service
        $name = $articleDocument->getTitle();
        $name = str_replace(' ', '-', strtolower($name));
        $articleDocument->setName($name);

        return $articleDocument;
    }

    /**
     * @return array
     */
    protected function getArticles()
    {
        $itemCount = 10;
        $articles = [];

        for ($i = 0; $i < $itemCount; $i++) {
            $articles[] = $this->createFakeArticleData();
        }

        return $articles;
    }

    /**
     * @return array
     */
    protected function createFakeArticleData()
    {
        $faker = Factory::create();

        $categories = ['alceane_side', 'in_my_backyard'];
        $key = random_int(0, 1);
        $category = $categories[$key];

        return [
            'title' => $faker->name,
            'body' => '<p>' . implode('</p><p>', $faker->paragraphs(5)) . '</p>',
            'category' => $category,
            'main_image' => __DIR__ . '/../../../../../web/assets/frontend/img/img-' . random_int(1, 3) . '.jpg'
        ];
    }

    /**
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.article_document');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('app.repository.article_document');
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('app.factory.article_document');
    }
}
