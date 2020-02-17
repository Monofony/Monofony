<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Page\Backend\Crud;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Behat\Mink\Exception\ElementNotFoundException;

interface CreatePageInterface extends SymfonyPageInterface
{
    /**
     * @param string $element
     *
     * @return string
     *
     * @throws ElementNotFoundException
     */
    public function getValidationMessage($element);

    /**
     * @throws ElementNotFoundException
     */
    public function create();
}
