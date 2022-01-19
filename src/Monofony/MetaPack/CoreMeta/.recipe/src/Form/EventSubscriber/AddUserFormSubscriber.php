<?php

declare(strict_types=1);

namespace App\Form\EventSubscriber;

use App\Form\Type\User\AppUserType;
use Sylius\Component\User\Model\UserAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Valid;
use Webmozart\Assert\Assert;

final class AddUserFormSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::SUBMIT => 'submit',
        ];
    }

    public function preSetData(FormEvent $event): void
    {
        $form = $event->getForm();
        $form->add('user', AppUserType::class, ['constraints' => [new Valid()]]);
        $form->add('createUser', CheckboxType::class, [
            'label' => 'app.ui.create_user',
            'required' => false,
            'mapped' => false,
        ]);
    }

    public function submit(FormEvent $event): void
    {
        $data = $event->getData();
        $form = $event->getForm();

        /* @var UserAwareInterface $data */
        Assert::isInstanceOf($data, UserAwareInterface::class);

        if (null === $data->getUser()->getId() && null === $form->get('createUser')->getViewData()) {
            $data->setUser(null);
            $event->setData($data);

            $form->remove('user');
            $form->add('user', AppUserType::class, ['constraints' => [new Valid()]]);
        }
    }
}
