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
use AppBundle\Document\QuestionBlock;
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
class LoadQuestionBlocksCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:question-blocks:load')
            ->setDescription('Load all question blocks.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command creates all question blocks.
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
            $output->writeln(sprintf("Loading block for <info>%s</info>", $data['title']));
            $block = $this->createOrReplaceBlock($data);
            $this->getManager()->persist($block);
        }

        $this->getManager()->flush();
    }

    /**
     * @param array $data
     *
     * @return QuestionBlock
     */
    protected function createOrReplaceBlock(array $data)
    {
        /** @var QuestionBlock $questionBlock */
        $questionBlock = $this->getRepository()->findOneBy(array('title' => $data['title']));

        if (null === $questionBlock) {
            $questionBlock = $this->getFactory()->createNew();
        }

        $questionBlock->setCategory($data['category']);
        $questionBlock->setTitle($data['title']);
        $questionBlock->setBody($data['body']);

        return $questionBlock;
    }

    /**
     * @return array
     */
    protected function getBlocks()
    {
        $blocks = [
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Quels sont les documents à conserver après la signature de mon bail ?',
                'body' => '<p>Vous devez lire et conserver votre contrat de location, le règlement intérieur et l’état des lieux d’entrée.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Pourquoi réaliser un état des lieux d\'entrée ?',
                'body' => '<p>L\'état des lieux constate l’état du logement lors de votre entrée. Toutes les imperfections que vous décèlerez sont à noter. Il vous sera nécessaire lors de votre départ du logement.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Ma situation familiale a changé, dois-je prévenir Alcéane ?',
                'body' => '<p>Oui, en fonction de l’évolution de votre situation familiale (mariage, divorce, naissance, décès) des documents sont à fournir à nos services. Pour plus d’informations, consultez le guide du locataire qui est disponible dans la rubrique "Votre guide du locataire". Si vous bénéficiez d\'une aide de la CAF, n\'oubliez pas de leur signaler également.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Quels sont les différents moyens de payer mon loyer ?',
                'body' => '<p>Alcéane met à votre disposition plusieurs moyens de paiement : par mandat de prélèvement, internet, carte bleue, chèque, TIP. Renseignez-vous auprès de notre service encaissements si vous souhaitez modifier votre moyen de paiement.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Quand dois-je payer mon loyer ?',
                'body' => '<p>Le règlement du loyer et des charges s’effectue mensuellement à terme échu (par exemple, fin février vous payez le loyer de février) et, au plus tard, dans les 10 jours suivant la réception de votre avis d’échéance. Si vous optez pour le prélèvement automatique, vous pouvez choisir d’être prélevé le 2, 7 ou 10 du mois.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Puis-je changer de logement ?',
                'body' => '<p>Oui, conformément à la législation, vous pouvez changer de logement mais sous certaines conditions et aux priorités par exemple agrandissement du foyer, mutation etc.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Quel est le délai pour donner son congé ?',
                'body' => '<p>Consultez votre contrat de location pour connaître le délai du préavis. Votre demande de résiliation doit être signée par tous les signataires du contrat de location et envoyée par courrier recommandé à Alcéane. Sans respect de ce délai, Alcéane est en droit de vous demander le paiement du loyer jusqu’à la fin du délai prévu.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Comment se déroule un état des lieux de sortie ?',
                'body' => '<p>L\'état des lieux de sortie s\'effectue dans un logement entièrement vidé et nettoyé. Vous devez également vider, si vous en avez, la cave, le grenier et le garage. Si vous n\'avez pas vidé et/ou nettoyé votre logement, vous serez alors facturé de la prestation.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Faut-il remettre le logement en état ?',
                'body' => '<p>Pour éviter de payer une facture trop importante pour les réparations locatives, nous vous conseillons, avant votre départ, d’effectuer une visite conseil avec un de nos techniciens. Prenez rendez-vous par téléphone au 0 232 850 850.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_USEFUL_INFORMATION,
                'title' => 'Quel est le délai pour récupérer ma caution ?',
                'body' => '<p>Vous pourrez récupérer votre caution dans les 2 mois uniquement si votre logement est rendu en bon état.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_MAINTENANCE_INFORMATION,
                'title' => 'Votre logement : Contrat Entretien et dépannage qui fait quoi ?',
                'body' => '<p>Pour faciliter vos démarches, Alcéane a mandaté un unique prestataire pour gérer les interventions techniques dans votre logement. ' .
                    'Entretien, dépannage, réparation, ce prestataire est à votre service pour résoudre rapidement vos demandes.</p>' .
                    '<p>Chaque année, vous bénéficierez également d’une visite qui permettra à votre prestataire de contrôler l’ensemble des équipements présents dans votre logement ' .
                    '(plomberie, sanitaire, robinetterie, menuiserie, électricité etc.).<p/>' .
                    '<p>Contactez votre prestataire Entretien & Dépannage pour vos demandes d’interventions en :'.
                    '<ul><li>Plomberie / robinetterie : Fuite ou casse d’un robinet, du mécanisme de chasse d’eau,'.
                    'fuite ou débouchage d’un évier, du lavabo ou des WC, débouchage des canalisations etc.</li>'.
                    '<li>Serrurerie / menuiserie : réparation de la poignée, serrure de la porte d’entrée ou'.
                    'intérieure, remplacement du mécanisme d’ouverture des fenêtres ou des lames de stores etc.</li>'.
                    '<li>Electricité : réparation de la sonnette, du combiné d’interphone, des prises électriques ou'.
                    'des interrupteurs, remplacement des appliques sanitaires etc.</li></ul></p>'.
                    '<p>Pour connaître le détail des interventions de votre prestataire Entretien & Dépannage, reportez-'.
                    'vous au Guide d’entretien de votre logement (lien téléchargement Guide CED). Vous pouvez contacter'.
                    'votre prestataire 7 jours sur 7 et 24 heures sur 24 pour une intervention sous 48 heures maximum, selon vos disponibilités.</p>'.
                    '<p>Si votre logement est équipé d’une chaudière individuelle, d’un chauffe-eau ou d’un cumulus individuel,'.
                    'votre prestataire pour l’entretien et les réparations est THERMIGAZ. Vous pouvez le contacter au <a href="tel:0800300218">0 800 300 218</a>.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_MAINTENANCE_INFORMATION,
                'title' => 'Qu’est-ce que la visite annuelle proposée par mon prestataire Entretien et Dépannage ?',
                'body' => '<p>Elle permet de vérifier le bon fonctionnement des équipements et de contrôler les éléments'.
                    'assurant votre sécurité. Cette visite est obligatoire et doit être réalisée tous les ans par votre'.
                    'prestataire Entretien & Dépannage.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_MAINTENANCE_INFORMATION,
                'title' => 'Mon prestataire Entretien et Dépannage peut-il refuser d’effectuer une intervention dans mon logement ?',
                'body' => '<p>Si la panne a été provoquée par des dégradations volontaires, un défaut d’entretien ou par'.
                    'négligence, le prestataire Entretien & Dépannage peut décider de ne pas assurer la réparation.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_MAINTENANCE_INFORMATION,
                'title' => 'Pour quelles demandes d’intervention dois-je contacter Alcéane ?',
                'body' => '<p>Vous pouvez contacter les services d’Alcéane pour les demandes relatives :'.
                    '<ul><li>Aux badges, clés, portiers phoniques, portes de caves ou boîte aux lettres.</li>'.
                    '<li>Aux volets roulants électriques</li>'.
                    '<li>Aux radiateurs à eau, radiateurs électriques ou sèche-serviettes</li>'.
                    '<li>Au revêtement de sol, à la faïence ou au carrelage mural</li>'.
                    '<li>A votre terrasse, balcon ou garde-corps</li>'.
                    '<li>A une infiltration façade ou à une présence de moisissure</li>'.
                    '<li>A une insuffisance de chauffage ou d’eau chaude ou pour une question sur la consommation d’eau chaude collective.</li>'.
                    '<li>A la présence de nuisibles (désinsectisation, dératisation, désinfection)</li>'.
                    '<li>A la réception TV (par antenne hertzienne collective uniquement).</li></ul></p>'.
                    '<p>Pour les demandes d’intervention dans les parties communes, rapprochez-vous de votre gestionnaire d’immeuble ou gardien.</p>',
            ],
            [
                'category' => QuestionBlock::CATEGORY_MAINTENANCE_INFORMATION,
                'title' => 'Que reste-t-il à ma charge ?',
                'body' => '<p>Pour les problèmes de réception TV (hors antenne hertzienne collective), de téléphonie ou'.
                    'd’internet, vous devez contacter votre opérateur. Les travaux d’embellissements de votre logement'.
                    '(peinture des murs et des plafonds) restent à votre charge.</p>'.
                    '<p>Pour les locataires de pavillon, vous devez vous occuper de l’entretien du jardin, du nettoyage'.
                    'des gouttières et des systèmes d’évacuation des eaux pluviales.</p>',
            ],
        ];

        return $blocks;
    }

    /**
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('app.manager.question_block');
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository()
    {
        return $this->getContainer()->get('app.repository.question_block');
    }

    /**
     * @return StringBlockFactory
     */
    protected function getFactory()
    {
        return $this->getContainer()->get('app.factory.question_block');
    }
}
