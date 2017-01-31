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

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * @author Laurent Baey <lbaey@mobizel.com>
 */
class LoadPdfDocumentsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:pdf-documents:load')
            ->setDescription('Load all PDF files.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all PDF files.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        $rootPath = $this->getContainer()->getParameter('kernel.root_dir') . '/../';
        $destinationPath = $rootPath . 'web/uploads/guides-pdf';

        $fs = new Filesystem();
        $fs->mkdir($destinationPath);

        $finder = new Finder();
        $finder->files()->in($rootPath . 'app/Resources/pdf/');

        foreach ($finder as $file) {
            $output->writeln(sprintf("Loading PDF with <info>%s</info> name", $file->getFilename()));
            $fs->copy($file->getRealPath(), $destinationPath . $file->getFilename());
        }

    }
}
