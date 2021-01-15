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

namespace Monofony\Bridge\Behat\Crud;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface CreatePageInterface extends SymfonyPageInterface
{
    /**
     * @throws ElementNotFoundException
     */
    public function getValidationMessage(string $element): string;

    /**
     * @throws ElementNotFoundException
     */
    public function create(): void;
}
