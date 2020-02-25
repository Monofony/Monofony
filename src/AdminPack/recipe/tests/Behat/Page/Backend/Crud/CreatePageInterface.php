<?php



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
