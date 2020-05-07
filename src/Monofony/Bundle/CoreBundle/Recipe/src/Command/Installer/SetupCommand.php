<?php

namespace App\Command\Installer;

use Doctrine\Common\Persistence\ObjectManager;
use Monofony\Component\Core\Model\User\AdminUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

final class SetupCommand extends Command
{
    /** @var ObjectManager */
    private $adminUserManager;

    /** @var FactoryInterface */
    private $adminUserFactory;

    /** @var UserRepositoryInterface */
    private $adminUserRepository;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(
        ObjectManager $adminUserManager,
        FactoryInterface $adminUserFactory,
        UserRepositoryInterface $adminUserRepository,
        ValidatorInterface $validator
    ) {
        $this->adminUserManager = $adminUserManager;
        $this->adminUserFactory = $adminUserFactory;
        $this->adminUserRepository = $adminUserRepository;
        $this->validator = $validator;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:install:setup')
            ->setDescription('AppName configuration setup.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command allows user to configure basic AppName data.
EOT
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setupAdministratorUser($input, $output);

        return 0;
    }

    protected function setupAdministratorUser(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('Create your administrator account.');

        try {
            $user = $this->configureNewUser($this->adminUserFactory->createNew(), $input, $output);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        $user->setEnabled(true);

        $this->adminUserManager->persist($user);
        $this->adminUserManager->flush();

        $output->writeln('Administrator account successfully registered.');
    }

    private function configureNewUser(
        AdminUserInterface $user,
        InputInterface $input,
        OutputInterface $output
    ): AdminUserInterface {
        if ($input->getOption('no-interaction')) {
            Assert::null($this->adminUserRepository->findOneByEmail('admin@example.com'));

            $user->setEmail('admin@example.com');
            $user->setUsername('admin');
            $user->setPlainPassword('admin');

            return $user;
        }

        $questionHelper = $this->getHelper('question');

        do {
            $question = $this->createEmailQuestion();
            $email = $questionHelper->ask($input, $output, $question);
            $exists = null !== $this->adminUserRepository->findOneByEmail($email);

            if ($exists) {
                $output->writeln('<error>E-Mail is already in use!</error>');
            }
        } while ($exists);

        $user->setEmail($email);
        $user->setUsername($email);
        $user->setPlainPassword($this->getAdministratorPassword($input, $output));

        return $user;
    }

    private function createEmailQuestion(): Question
    {
        return (new Question('E-mail:'))
            ->setValidator(function ($value) {
                /** @var ConstraintViolationListInterface $errors */
                $errors = $this->validator->validate((string) $value, [new Email(), new NotBlank()]);
                foreach ($errors as $error) {
                    throw new \DomainException($error->getMessage());
                }

                return $value;
            })
            ->setMaxAttempts(3)
            ;
    }

    /**
     * @return mixed
     */
    private function getAdministratorPassword(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $questionHelper */
        $questionHelper = $this->getHelper('question');
        $validator = $this->getPasswordQuestionValidator();

        do {
            $passwordQuestion = $this->createPasswordQuestion('Choose password:', $validator);
            $confirmPasswordQuestion = $this->createPasswordQuestion('Confirm password:', $validator);

            $password = $questionHelper->ask($input, $output, $passwordQuestion);
            $repeatedPassword = $questionHelper->ask($input, $output, $confirmPasswordQuestion);

            if ($repeatedPassword !== $password) {
                $output->writeln('<error>Passwords do not match!</error>');
            }
        } while ($repeatedPassword !== $password);

        return $password;
    }

    /**
     * @return \Closure
     */
    private function getPasswordQuestionValidator()
    {
        return function ($value) {
            /** @var ConstraintViolationListInterface $errors */
            $errors = $this->validator->validate($value, [new NotBlank()]);
            foreach ($errors as $error) {
                throw new \DomainException($error->getMessage());
            }

            return $value;
        };
    }

    /**
     * @param string $message
     * @param \Closure $validator
     *
     * @return Question
     */
    private function createPasswordQuestion($message, \Closure $validator)
    {
        return (new Question($message))
            ->setValidator($validator)
            ->setMaxAttempts(3)
            ->setHidden(true)
            ->setHiddenFallback(false)
            ;
    }
}
