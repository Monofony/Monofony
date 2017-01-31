<?php
/**
 * Created by PhpStorm.
 * User: loic
 * Date: 07/04/2016
 * Time: 17:42
 */

namespace AppBundle\Command\Installer;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class InstallDataCommand extends AbstractInstallCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:install:data')
            ->setDescription('Install Alcéane data.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command installs Alcéane data.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf('Loading Alcéane data for environment <info>%s</info>.', $this->getEnvironment()));


        $commands = [
            'app:root-taxons:load',
            'app:cities:load',
            'app:product-types:load',
            'app:product-categories:load',
            'app:product-attributes:load',
            'app:job-offers:load',
            'app:products:load',
            'app:article-documents:load',
            'app:magazines:load',
            'app:achievements:load',
            'app:string-blocks:load',
            'app:question-blocks:load',
            'app:building-managers:load',
            'app:import:contract' => [
                'archive_path' => $kernelRootDir = $this->getContainer()->getParameter('kernel.root_dir') . '/../transfert/EXTRA_DONNEES.tar.gz'
            ]
        ];

        $this->runCommands($commands, $input, $output);
    }
}