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

interface SharedStorageInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key);

    public function has(string $key): bool;

    public function set(string $key, $resource): void;

    /**
     * @return mixed
     */
    public function getLatestResource();

    /**
     * @param array $clipboard
     *
     * @throws \RuntimeException
     */
    public function setClipboard(array $clipboard);
}
