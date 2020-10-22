<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monofony\Component\Admin\Behat\Crud;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Behat\Mink\Exception\ElementNotFoundException;

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
