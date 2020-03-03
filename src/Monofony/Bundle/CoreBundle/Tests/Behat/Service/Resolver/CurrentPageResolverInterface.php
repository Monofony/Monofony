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

namespace Monofony\Bundle\CoreBundle\Tests\Behat\Service\Resolver;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface CurrentPageResolverInterface
{
    /**
     * @param SymfonyPageInterface[] $pages
     *
     * @return SymfonyPageInterface
     */
    public function getCurrentPageWithForm(array $pages);
}
