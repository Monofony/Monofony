<?php

declare(strict_types=1);

namespace spec\Sylius\Bundle\CoreBundle\Form\EventSubscriber;

use App\Entity\Customer;
use PhpSpec\ObjectBehavior;
use App\Entity\AppUser;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

final class CustomerRegistrationFormSubscriberSpec extends ObjectBehavior
{
    function let(RepositoryInterface $customerRepository): void
    {
        $this->beConstructedWith($customerRepository);
    }

    function it_is_event_subscriber_instance(): void
    {
        $this->shouldImplement(EventSubscriberInterface::class);
    }

    function it_listens_on_pre_submit_data_event(): void
    {
        $this->getSubscribedEvents()->shouldReturn([FormEvents::PRE_SUBMIT => 'preSubmit']);
    }

    function it_sets_user_for_existing_customer(
        FormEvent $event,
        FormInterface $form,
        Customer $customer,
        RepositoryInterface $customerRepository,
        Customer $existingCustomer,
        AppUser $user
    ): void {
        $event->getForm()->willReturn($form);
        $form->getData()->willReturn($customer);
        $event->getData()->willReturn(['email' => 'sylius@example.com']);

        $customerRepository->findOneBy(['email' => 'sylius@example.com'])->willReturn($existingCustomer);

        $existingCustomer->getUser()->willReturn(null);
        $customer->getUser()->willReturn($user);

        $existingCustomer->setUser($user)->shouldBeCalled();
        $form->setData($existingCustomer)->shouldBeCalled();

        $this->preSubmit($event);
    }

    function it_throws_unexpected_type_exception_if_data_is_not_customer_type(
        FormEvent $event,
        FormInterface $form,
        AppUser $user
    ): void {
        $event->getForm()->willReturn($form);
        $form->getData()->willReturn($user);
        $event->getData()->willReturn(['email' => 'sylius@example.com']);

        $this->shouldThrow(\InvalidArgumentException::class)->during('preSubmit', [$event]);
    }

    function it_does_not_set_user_if_customer_with_given_email_has_set_user(
        FormEvent $event,
        FormInterface $form,
        Customer $customer,
        RepositoryInterface $customerRepository,
        Customer $existingCustomer,
        AppUser $user
    ): void {
        $event->getForm()->willReturn($form);
        $form->getData()->willReturn($customer);
        $event->getData()->willReturn(['email' => 'sylius@example.com']);

        $customerRepository->findOneBy(['email' => 'sylius@example.com'])->willReturn($existingCustomer);

        $existingCustomer->getUser()->willReturn($user);

        $existingCustomer->setUser($user)->shouldNotBeCalled();
        $form->setData($existingCustomer)->shouldNotBeCalled();

        $this->preSubmit($event);
    }
}
