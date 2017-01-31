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

use AppBundle\Entity\JobOffer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Faker\Factory;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class LoadJobOffersCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:job-offers:load')
            ->setDescription('Load all job offers.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all job offers.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getJobOffers() as $data) {
            $output->writeln(sprintf("Loading job offer with <info>%s</info> code", $data['code']));
            $attribute = $this->createOrReplaceJobOffer($data);
            $this->getManager()->persist($attribute);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return JobOffer
     */
    protected function createOrReplaceJobOffer(array $data)
    {
        /** @var JobOffer $jobOffer */
        $jobOffer = $this->getRepository()->findOneBy(array('code' => $data['code']));

        if (null === $jobOffer) {
            $jobOffer = $this->getFactory()->createNew();
        }

        $jobOffer
            ->setCode($data['code'])
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setUnit($data['unit'])
            ->setCity($data['city'])
            ->setContract($data['contract'])
            ->setEnabled($data['enabled']);

        return $jobOffer;
    }

    /**
     * @return array
     */
    protected function getJobOffers()
    {
        $itemCount = 20;
        $jobOffers = [];

        for ($i = 0; $i < $itemCount; $i++) {
            $jobOffers[] = $this->createFakeJobOfferData();
        }

        return $jobOffers;
    }

    protected function createFakeJobOfferData()
    {
        $faker = Factory::create();

        $contracts = ['CDD', 'CDI'];
        $key = random_int(0, 1);
        $contract = $contracts[$key];

        $description = <<<EOF
<h4>Description du poste</h4>
            <p>Par votre présence quotidienne au cœur du patrimoine, vous permettez aux habitants de bénéficier de la jouissance paisible des lieux, d’un bon fonctionnement des installations, et d’un environnement respectueux des règles de propreté, hygiène et sécurité. Rattaché au responsable de territoire, vous êtes garant de la qualité du service et vous gérez un patrimoine d’environ 500 logements pour lequel vous contrôlez l’ensemble des interventions.</p>
            <h4>A ce titre, vos missions de surveillance et de présence terrain sont les suivantes :</h4>
            <ul>
                <li>Faire respecter le règlement intérieur des immeubles par les locataires.</li>
                <li>Réguler les relations sociales entre habitants.</li>
                <li>Contrôler les équipements et l’application des règles de sécurité.</li>
                <li>Réaliser les visites de logements vacants et les états des lieux entrants en étroite collaboration avec les chargés de gestion locative.</li>
                <li>Concourir au maintien en état de propreté des groupes dont le nettoyage et la gestion des ordures ménagères peuvent être assurés par des équipes internes ou des prestataires.</li>
                <li>Prendre en charge les réclamations et veiller à la bonne exécution et la qualité des interventions et travaux.</li>
                <li>Participer à la maintenance du patrimoine au travers d’une veille permanente de l’état d’entretien du parc immobilier et de ses abords.</li>
            </ul>
            <h4>Profil :</h4>
            <ul>
                <li>Formation Bac +2 dans les domaines de la gestion immobilière, bâtiment ou maintenance, avec une expérience souhaitée de 1 à 3 ans dans une fonction similaire.</li>
                <li>Connaissances des techniques du bâti et de la législation applicable au secteur immobilier (bail, charges et réparations locatives…).</li>
                <li>Capacités d’analyse et de diagnostic.</li>
                <li>Maîtrise des outils bureautiques.</li>
                <li>Aisance relationnelle.</li>
                <li>Aptitude à la médiation et la maîtrise de soi.</li>
                <li>Aptitude à s’affirmer.</li>
                <li>Sens de l’organisation, gestion des priorités.</li>
                <li>Autonomie, prise d’initiatives.</li>
            </ul>
            <h4>Salaire :</h4>
            <p>Le salaire proposé: Entre 19 500€ et 22 000€ selon profil.</p>
EOF;


        return [
            'code' => $faker->postcode,
            'name' => $faker->name,
            'description' => $description,
            'unit' => $faker->jobTitle,
            'city' => $faker->city,
            'contract' => $contract,
            'enabled' => $faker->boolean(70),
        ];
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.job_offer');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('app.repository.job_offer');
    }

    /**
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('app.factory.job_offer');
    }
}
