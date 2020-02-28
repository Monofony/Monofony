<?php

namespace App\Context;

use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class CustomerContext implements CustomerContextInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @param TokenStorageInterface         $tokenStorage
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Gets customer based on currently logged user.
     *
     * @return CustomerInterface|null
     */
    public function getCustomer(): ?CustomerInterface
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED') && $token->getUser() instanceof UserInterface) {
            return $token->getUser()->getCustomer();
        }

        return null;
    }
}
