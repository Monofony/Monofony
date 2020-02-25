<?php



namespace App\Tests\Behat\Service\Setter;

interface CookieSetterInterface
{
    /**
     * @param string $name
     * @param string $value
     */
    public function setCookie($name, $value);
}
