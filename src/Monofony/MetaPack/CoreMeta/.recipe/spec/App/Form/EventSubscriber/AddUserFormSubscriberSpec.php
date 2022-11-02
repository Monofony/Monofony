<?php

declare(strict_types=1);

namespace spec\App\Form\EventSubscriber;

use App\Form\Type\User\AppUserType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\User\Model\UserAwareInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Valid;

final class AddUserFormSubscriberSpec extends ObjectBehavior
{
    function it_is_event_subscriber_instance(): void
    {
        $this->shouldImplement(EventSubscriberInterface::class);
    }

    function it_subscribes_to_events(): void
    {
        $this::getSubscribedEvents()->shouldReturn([
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::SUBMIT => 'submit',
        ]);
    }

    function it_adds_user_form_type_and_create_user_check(
        FormEvent $event,
        Form $form
    ): void {
        $event->getForm()->willReturn($form);

        $form->add('user', AppUserType::class, [
            'constraints' => [new Valid()],
        ])->willReturn($form)->shouldBeCalled();
        $form->add('createUser', Argument::type('string'), [
            'label' => 'app.ui.create_user',
            'required' => false,
            'mapped' => false,
        ])->willReturn($form)->shouldBeCalled();

        $this->preSetData($event);
    }

    function it_replaces_user_form_by_new_user_form_when_create_user_check_is_not_checked(
        FormEvent $event,
        Form $form,
        Form $createUserCheckForm,
        UserAwareInterface $customer,
        UserInterface $user
    ): void {
        $event->getData()->willReturn($customer);
        $event->getForm()->willReturn($form);

        $customer->getUser()->willReturn($user);
        $user->getId()->willReturn(null);

        $form->get('createUser')->willReturn($createUserCheckForm);
        $createUserCheckForm->getViewData()->willReturn(null);

        $customer->setUser(null)->shouldBeCalled();
        $event->setData($customer)->shouldBeCalled();

        $form->remove('user')->willReturn($form)->shouldBeCalled();
        $form->add('user', AppUserType::class, ['constraints' => [new Valid()]])->willReturn($form)->shouldBeCalled();

        $this->submit($event);
    }

    function it_does_not_replace_user_form_by_new_user_form_when_create_user_check_is_checked(
        FormEvent $event,
        Form $form,
        Form $createUserCheckForm,
        UserAwareInterface $customer,
        UserInterface $user
    ): void {
        $event->getData()->willReturn($customer);
        $event->getForm()->willReturn($form);

        $customer->getUser()->willReturn($user);
        $user->getId()->willReturn(null);

        $form->get('createUser')->willReturn($createUserCheckForm);
        $createUserCheckForm->getViewData()->willReturn('1');

        $customer->setUser(null)->shouldNotBeCalled();
        $event->setData($customer)->shouldNotBeCalled();

        $form->remove('user')->shouldNotBeCalled();
        $form->add('user', AppUserType::class, Argument::type('array'))->shouldNotBeCalled();

        $this->submit($event);
    }

    function it_does_not_replace_user_form_by_new_user_form_when_user_has_an_id(
        FormEvent $event,
        Form $form,
        Form $createUserCheckForm,
        UserAwareInterface $customer,
        UserInterface $user
    ): void {
        $event->getData()->willReturn($customer);
        $event->getForm()->willReturn($form);

        $customer->getUser()->willReturn($user);
        $user->getId()->willReturn(1);

        $form->get('createUser')->willReturn($createUserCheckForm);
        $createUserCheckForm->getViewData()->willReturn(null);

        $customer->setUser(null)->shouldNotBeCalled();
        $event->setData($customer)->shouldNotBeCalled();

        $form->remove('user')->shouldNotBeCalled();
        $form->add('user', AppUserType::class, Argument::type('array'))->shouldNotBeCalled();

        $this->submit($event);
    }

    function it_throws_invalid_argument_exception_when_data_does_not_implement_user_aware_interface(
        FormEvent $event,
        Form $form,
        Form $createUserCheckForm,
        UserInterface $user
    ): void {
        $event->getData()->willReturn($user);
        $event->getForm()->willReturn($form);
        $form->get('createUser')->willReturn($createUserCheckForm);
        $createUserCheckForm->getViewData()->willReturn(null);

        $this->shouldThrow(\InvalidArgumentException::class)->during('submit', [$event]);
    }
}
