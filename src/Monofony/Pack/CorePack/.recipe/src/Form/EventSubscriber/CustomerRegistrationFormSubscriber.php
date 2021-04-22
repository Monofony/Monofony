<?php

declare(strict_types=1);

namespace App\Form\EventSubscriber;

use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class CustomerRegistrationFormSubscriber implements EventSubscriberInterface
{
    private RepositoryInterface $customerRepository;

    public function __construct(RepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function preSubmit(FormEvent $event): void
    {
        $rawData = $event->getData();
        $form = $event->getForm();
        $data = $form->getData();

        if (!$data instanceof CustomerInterface) {
            throw new UnexpectedTypeException($data, CustomerInterface::class);
        }

        // if email is not filled in, go on
        if (!isset($rawData['email']) || empty($rawData['email'])) {
            return;
        }
        $existingCustomer = $this->customerRepository->findOneBy(['email' => $rawData['email']]);
        if (null === $existingCustomer || null !== $existingCustomer->getUser()) {
            return;
        }

        $existingCustomer->setUser($data->getUser());
        $form->setData($existingCustomer);
    }
}
