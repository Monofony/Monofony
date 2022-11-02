<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Monofony\Bridge\Behat\Service;

use Monofony\Bridge\Behat\Service\Setter\CookieSetterInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

abstract class AbstractSecurityService implements SecurityServiceInterface
{
    private string $sessionTokenVariable;

    public function __construct(
        private RequestStack $requestStack,
        private CookieSetterInterface $cookieSetter,
        private string $firewallContextName,
        private SessionFactoryInterface $sessionFactory,
    ) {
        $this->sessionTokenVariable = sprintf('_security_%s', $firewallContextName);
    }

    /**
     * {@inheritdoc}
     *
     * @psalm-suppress InvalidArgument
     */
    public function logIn(UserInterface $user): void
    {
        $token = new UsernamePasswordToken($user, $this->firewallContextName, $user->getRoles());
        $this->setToken($token);
    }

    public function logOut(): void
    {
        try {
            $this->setTokenCookie();
        } catch (SessionNotFoundException) {
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentToken(): TokenInterface
    {
        $serializedToken = $this->requestStack->getSession()->get($this->sessionTokenVariable);

        if (null === $serializedToken) {
            throw new TokenNotFoundException();
        }

        return unserialize($serializedToken);
    }

    /**
     * {@inheritdoc}
     */
    public function restoreToken(TokenInterface $token): void
    {
        $this->setToken($token);
    }

    private function setToken(TokenInterface $token): void
    {
        $session = $this->sessionFactory->createSession();
        $request = new Request();
        $request->setSession($session);
        $this->requestStack->push($request);

        $this->setTokenCookie(serialize($token));
    }

    private function setTokenCookie($serializedToken = null): void
    {
        $session = $this->requestStack->getSession();
        $session->set($this->sessionTokenVariable, $serializedToken);
        $session->save();
        $this->cookieSetter->setCookie($session->getName(), $session->getId());
    }
}
