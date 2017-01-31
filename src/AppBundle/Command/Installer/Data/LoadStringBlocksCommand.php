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
use AppBundle\Document\StringBlock;
use AppBundle\Factory\StringBlockFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Faker\Factory;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Laurent Baey <lbaey@mobizel.com>
 */
class LoadStringBlocksCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:string-blocks:load')
            ->setDescription('Load all string blocks.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all administrable blocks.
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(sprintf("<comment>%s</comment>", $this->getDescription()));

        foreach ($this->getBlocks() as $data) {
            $output->writeln(sprintf("Loading block for <info>%s</info>", $data['name']));
            $block = $this->createOrReplaceBlock($data);
            $this->getManager()->persist($block);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return StringBlock
     */
    protected function createOrReplaceBlock(array $data)
    {
        /** @var StringBlock $stringBlock */
        $stringBlock = $this->getRepository()->findOneBy(array('name' => $data['name']));

        if (null === $stringBlock) {
            $stringBlock = $this->getFactory()->createNew();
        }

        $stringBlock->setName($data['name']);
        $stringBlock->setBody($data['body']);

        return $stringBlock;
    }

    /**
     * @return array
     */
    protected function getBlocks()
    {
        $blocks = [];

        $blocks[] = [
            'name' => 'account-badge-nota',
            'body' => '<p>La commande de badge est payante et donnera lieu à une facturation.</p>
            <p>Pour compléter votre demande, nos services prendront contact avec vous suivant nos horaires, du lundi au
                vendredi de 8h30 à 16h30.<br/>
                Vous recevrez une copie du mail adressé à nos services, sur l’adresse que vous indiquerez dans ce
                formulaire.</p>',
        ];

        $blocks[] = [
            'name' => 'logista',
            'body' => '<ul>
                        <li>Logista</li>
                        <li><strong>tél. :</strong> 02 33 41 21 54</li>
                    </ul>',
        ];

        $blocks[] = [
            'name' => 'iserba',
            'body' => '<ul>
                        <li>Iserba</li>
                        <li><strong>tél. :</strong> 02 33 41 21 54</li>
                    </ul>',
        ];

        $blocks[] = [
            'name' => 'info-iserba',
            'body' => '<li>
                            <span><i>Iserba</i><br>Tél. : 0 800 57 42 73</span>
                            Entretien ou remplacement de votre robinetterie (joint, robinet, chasse d\'eau...)
                        </li>',
        ];

        $blocks[] = [
            'name' => 'info-logista',
            'body' => '<li>
                            <span><i>Logista</i><br>Tél. : 0 800 57 42 73</span>
                            Entretien ou remplacement de votre robinetterie (joint, robinet, chasse d\'eau...)
                        </li>',
        ];

        $blocks[] = [
            'name' => 'info-thermigaz',
            'body' => '<li>
                            <span><i>Thermigaz</i><br>Tél. : 0 800 300 218</span>
                            Entretien de votre chaudière, chauffe-eau ou cumulus
                        </li>',
        ];

        $blocks[] = [
            'name' => 'info-erdf-depannage',
            'body' => '<li>
                            <span><i>ERDF Dépannage</i><br>Tél. : 09 72 67 50 76</span>
                        </li>',
        ];

        $blocks[] = [
            'name' => 'info-grdf-depannage',
            'body' => '<li>
                            <span><i>GRDF Dépannage</i><br>Tél. : 0 800 47 33 33</span>
                        </li>',
        ];

        $blocks[] = [
            'name' => 'info-encombrements-ville-du-havre',
            'body' => '<li>
                            <span><i>Encombrements Ville du Havre</i><br>Tél. : 0 800 35 10 11</span>
                        </li>',
        ];

        $blocks[] = [
            'name' => 'informatique-et-liberte',
            'body' => '<p><small><strong>Informatique et Libertés :</strong>
                        <br/>En vertu de l\'article 27 de la loi n°78-17 du 6 janvier 1978 relative à l\'informatique, aux
                        fichiers et
                        aux libertés, vous disposez d\'un droit d\'accès, de modification, de rectification et de
                        suppression des
                        données qui vous concernent.</small></p>',
        ];


        $blocks[] = [
            'name' => 'about-presentation',
            'body' => '
                    <img src="/assets/frontend/img/template/about/siege-3.jpg" alt="" class="img/responsive">
                    <div class="row">
                        <div class="small-12 large-6 columns text">
                            <h3>Quand longévité rime avec modernité</h3>
                            <p>Construire, réhabiliter, parfois démolir, font partie de nos missions depuis 100 ans et constituent l\'activité la plus visible. Notre métier est certes avant tout de loger, de bien loger, mais également de nous occuper du quotidien et de la qualité de vie de nos locataires en améliorant la propreté des espaces communs, en optimisant la gestion des espaces verts, en maîtrisant les consommations d’énergie, en réglant les réclamations au plus vite, en adaptant nos logements au vieillissement de leurs occupants et aux handicaps, en sécurisant nos halls d’immeubles, en traitant au mieux les incivilités, bref, en oeuvrant pour le vivre ensemble et la cohésion sociale.</p>
                        </div>
                        <div class="small-12 large-6 columns text">
                            <h3>100% au service des locataires</h3>
                            <p>Pour remplir toutes ces missions, il faut y croire ! Sans le professionnalisme de nos 321 salariés, tout cela ne serait qu’un rêve inaccessible ! Toutes nos équipes œuvrent quotidiennement auprès de nos locataires car ils sont le fondement de notre action : faciliter leur accueil et leur emménagement, améliorer leur cadre de vie, les informer, les accompagner en cas de difficulté : des salariés engagés et dédiés à nos locataires.</p>
                            <a href="/uploads/guides-pdf/organigramme.pdf" class="button" target="_blank">Organigramme</a><span class="button-details">(PDF, 51 ko)</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="small-12 large-6 columns text">
                            <h3>Les instances décisionnelles</h3>
                            <h4>Le conseil d’administration</h4>
                            <p>Il exerce sa compétence d’orientation générale et de contrôle de l’activité d’Alcéane. L’action du Conseil d\'Administration est complétée par le Bureau qui, par délégation, gère les questions de gestion courante pour une meilleure souplesse et réactivité décisionnelles.</p>
                            <ul>
                                <li>Agnès Firmin-Le Bodo (Présidente)</li>
                                <li>Daniel Fidelin (Vice-Président)</li>
                                <li>Jean-Paul Lecoq</li>
                                <li>Gilbert Conan (Vice-Président)</li>
                                <li>Marie-Laure Drone</li>
                                <li>Régis Debons</li>
                                <li>Pascale Chérif</li>
                                <li>Alain Fleuret</li>
                                <li>Mireille Garcia</li>
                                <li>Jacqueline Marais</li>
                                <li>Jean-François Masse</li>
                                <li>Jean Moulin</li>
                                <li>Bineta Niang</li>
                                <li>Jean-Claude Métayer</li>
                                <li>Thierry Delpeches</li>
                                <li>Claude Legrand</li>
                                <li>Jean-Marc Olivier</li>
                                <li>Chantal Andrieu</li>
                                <li>Alain Levasseur</li>
                                <li>Christian Chatigny</li>
                                <li>Yamina Collino</li>
                                <li>Jean-Baptiste Longuet</li>
                                <li>Rose-Blanche Pelaud</li>
                            </ul>
                        </div>
                        <div class="small-12 large-6 columns text">
                            <h4>La Commission d\'Attribution des Logements (CAL)</h4>
                            <p>Chaque semaine, la CAL attribue les logements après étude des dossiers des candidats selon les critères définis (ressources, situation familiale, typologie du logement...).</p>
                            <a href="/uploads/guides-pdf/reglement-interieur-commission-attribution-logement.pdf" target="_blank">&gt; Règlement intérieur de la CAL</a>
                            <a href="/uploads/guides-pdf/orientations-applicables-pour-l-attribution-des-logements.pdf" target="_blank">&gt; Orientations applicables pour l\'attribution des logements</a>
                            <h4>Le Commission d\'Appel d\'Offres (CAO)</h4>
                            <p>La CAO analyse les offres des entreprises et désigne les attributaires des marchés passés en garantissant le respect des principes du code des marchés publics.</p>
                        </div>
                    </div>',
        ];

        $blocks[] = [
            'name' => 'about-historique',
            'body' => '
                    <div class="row">
                        <div class="hide-for-small-only medium-6 columns img-small">
                            <img src="/assets/frontend/img/template/about/historique_photo1.png">
                        </div>
                        <div class="small-12 medium-6 columns textright top">
                            <img class="show-for-small-only" src="/assets/frontend/img/template/about/historique_photo1.png">
                            <div class="date">
                                <h4>4 décembre 1914</h4>
                                <p>Création par décret de l’Office Public d’Habitations à Bon Marché (OPHBM). L’OPHBM deviendra dans les années 50 l’Office Public d’HLM (OPHLM)</p>
                            </div>
                            <div class="date">
                                <h4>De 1920 à 1934</h4>
                                <p>L’Office engage ses premières constructions&nbsp;:</p>
                                <ul>
                                    <li>228 pavillons de la Cité jardins de Haut-Graville (1922)</li>
                                    <li>120 logements du Parc d’Or (1926)</li>
                                    <li>Tourneville (1931 – 1934)</li>
                                </ul>
                            </div>
                            <div class="date">
                                <h4>Après la seconde guerre mondiale</h4>
                                <p>La ville du Havre est détruite et l’Office apporte une contribution significative à sa reconstruction&nbsp;: 58% des logements de son parc actuel ont été construits entre 1948 et 1970.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row bg-gray">
                        <div class="small-12 medium-6 columns textleft center">
                            <img class="show-for-small-only" src="/assets/frontend/img/template/about/historique_photo2.png">
                            <div class="date">
                                <h4>Durant les années 70-80</h4>
                                <p>L’Office s’engage dans plusieurs programmes d’amélioration du patrimoine ancien comme Habitat Vie Sociale (HVS) et Développement Social des Quartiers (DSQ) </p>
                            </div>
                            <div class="date">
                                <h4>5 octobre 2004</h4>
                                <p>L’Office signe la Convention ANRU avec la Ville du Havre pour rénover plusieurs quartiers du Havre.</p>
                            </div>
                            <div class="date">
                                <h4>Décembre 2005</h4>
                                <p>L’OPHLM Le Havre change de statut et d’identité et devient Alcéane. La politique de rénovation est renforcée et s’efforce de placer l’homme au cœur de l’habitat.</p>
                            </div>
                        </div>
                        <div class="hide-for-small-only medium-6 columns img-small">
                            <img src="/assets/frontend/img/template/about/historique_photo2.png">
                        </div>
                    </div>
                    <div class="row">
                        <div class="hide-for-small-only medium-6 columns img-small">
                            <img src="/assets/frontend/img/template/about/historique_photo3.png">
                        </div>
                        <div class="small-12 medium-6 columns textright bottom">
                            <img class="show-for-small-only" src="/assets/frontend/img/template/about/historique_photo3.png">
                            <div class="date">
                                <h4>4 décembre 2014</h4>
                                <p>Alcéane fête son centenaire.</p>
                            </div>
                            <div class="date">
                                <h4>1er février 2015</h4>
                                <p>Alcéane est rattaché à la communauté d’agglomération havraise (CODAH)</p>
                            </div>
                            <div class="date">
                                <h4>9 juin 2015</h4>
                                <p>Alcéane emménage dans son nouveau siège social à la Mare-Rouge.</p>
                            </div>
                        </div>
                    </div>',
        ];

        return $blocks;
    }

    /**
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.string_block');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('app.repository.string_block');
    }

    /**
     * @return StringBlockFactory
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('app.factory.string_block');
    }
}
