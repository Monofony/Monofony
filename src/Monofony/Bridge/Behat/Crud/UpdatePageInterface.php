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

interface UpdatePageInterface extends SymfonyPageInterface
{
    /**
     * @throws ElementNotFoundException
     */
    public function getValidationMessage(string $element): string;

    /**
     * @param array $parameters where keys are some of arbitrary elements defined by user and values are expected values
     */
    public function hasResourceValues(array $parameters): bool;

    public function saveChanges(): void;
}
