<?php

namespace App\Form\EventSubscriber;

use Sylius\Component\User\Model\UserAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Valid;
use Webmozart\Assert\Assert;

final class AddUserFormSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $entryType;

    /**
     * @param string $entryType
     */
    public function __construct($entryType)
    {
        $this->entryType = $entryType;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::SUBMIT => 'submit',
        ];
    }

    /**
     * @param FormEvent $event
     */
    public function preSetData(FormEvent $event)
    {
        $form = $event->getForm();
        $form->add('user', $this->entryType, ['constraints' => [new Valid()]]);
        $form->add('createUser', CheckboxType::class, [
            'label' => 'app.ui.create_user',
            'required' => false,
            'mapped' => false,
        ]);
    }

    /**
     * @param FormEvent $event
     */
    public function submit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        /** @var UserAwareInterface $data */
        Assert::isInstanceOf($data, UserAwareInterface::class);

        if (null === $data->getUser()->getId() && null === $form->get('createUser')->getViewData()) {
            $data->setUser(null);
            $event->setData($data);

            $form->remove('user');
            $form->add('user', $this->entryType, ['constraints' => [new Valid()]]);
        }
    }
}
