<?php

/*
 * This file is part of Jedisjeux.
 *
 * (c) Loïc Frémont
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Page;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
interface SymfonyPageInterface
{
    /**
     * @return string
     */
    public function getRouteName();
}
