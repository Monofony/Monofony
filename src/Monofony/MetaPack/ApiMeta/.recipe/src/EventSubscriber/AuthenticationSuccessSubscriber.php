<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ApiPlatform\Api\IriConverterInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Sylius\Component\Customer\Model\CustomerAwareInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class AuthenticationSuccessSubscriber implements EventSubscriberInterface
{
    public function __construct(private IriConverterInterface $iriConverter)
    {
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof CustomerAwareInterface) {
            return;
        }

        $data['customer'] = $this->iriConverter->getIriFromResource($user->getCustomer());

        $event->setData($data);
    }

    public static function getSubscribedEvents(): array
    {
        return [Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccessResponse'];
    }
}
