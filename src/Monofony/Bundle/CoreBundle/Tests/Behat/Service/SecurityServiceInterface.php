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

namespace Monofony\Bundle\CoreBundle\Tests\Behat\Service;

use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

interface SecurityServiceInterface
{
    /**
     * @param UserInterface $user
     *
     * @throws \InvalidArgumentException
     */
    public function logIn(UserInterface $user);

    public function logOut();

    /**
     * @return TokenInterface
     *
     * @throws TokenNotFoundException
     */
    public function getCurrentToken();

    /**
     * @param TokenInterface $token
     */
    public function restoreToken(TokenInterface $token);
}
