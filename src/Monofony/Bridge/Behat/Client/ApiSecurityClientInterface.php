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

namespace Monofony\Bridge\Behat\Client;

interface ApiSecurityClientInterface
{
    public function prepareLoginRequest(): void;

    public function setEmail(string $email): void;

    public function setPassword(string $password): void;

    public function call(): void;

    public function isLoggedIn(): bool;

    public function getErrorMessage(): string;

    public function logOut(): void;
}
