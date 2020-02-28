<?php



namespace App\Tests\Behat\Page\Backend\Crud;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Behat\Mink\Exception\ElementNotFoundException;

interface UpdatePageInterface extends SymfonyPageInterface
{
    /**
     * @throws ElementNotFoundException
     */
    public function getValidationMessage(string $element): string;

    /**
     * @param array $parameters where keys are some of arbitrary elements defined by user and values are expected values
     *
     * @return bool
     */
    public function hasResourceValues(array $parameters): bool;

    public function saveChanges(): void;
}
