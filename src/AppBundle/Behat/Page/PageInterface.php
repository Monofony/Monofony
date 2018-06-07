<?php

/*
 * This file is part of Jedisjeux.
 *
 * (c) Loïc Frémont
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Page;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
interface PageInterface
{
    /**
     * @param array $urlParameters
     *
     * @throws UnexpectedPageException If page is not opened successfully
     */
    public function open(array $urlParameters = []);

    /**
     * @param array $urlParameters
     */
    public function tryToOpen(array $urlParameters = []);

    /**
     * @param array $urlParameters
     *
     * @throws UnexpectedPageException
     */
    public function verify(array $urlParameters = []);

    /**
     * @param array $urlParameters
     *
     * @return bool
     */
    public function isOpen(array $urlParameters = []);
}
