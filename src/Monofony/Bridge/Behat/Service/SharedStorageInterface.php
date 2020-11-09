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

interface SharedStorageInterface
{
    /**
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
     * @throws \RuntimeException
     */
    public function setClipboard(array $clipboard);
}
