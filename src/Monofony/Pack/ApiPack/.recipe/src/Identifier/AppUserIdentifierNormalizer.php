<?php

declare(strict_types=1);

namespace App\Identifier;

use Monofony\Contracts\Api\Identifier\AppUserIdentifierNormalizerInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Security;

final class AppUserIdentifierNormalizer implements AppUserIdentifierNormalizerInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * {@inheritdoc}
     *
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        $user = $this->security->getUser();

        if (null === $user || !$user instanceof AppUserInterface) {
            throw new AccessDeniedHttpException();
        }

        return (string) $user->getCustomer()->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return 'me' === $data;
    }
}
