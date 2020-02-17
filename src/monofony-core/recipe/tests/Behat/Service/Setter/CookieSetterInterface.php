<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Service\Setter;

interface CookieSetterInterface
{
    /**
     * @param string $name
     * @param string $value
     */
    public function setCookie($name, $value);
}
