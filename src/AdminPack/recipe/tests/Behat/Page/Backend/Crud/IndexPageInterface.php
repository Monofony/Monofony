<?php



namespace App\Tests\Behat\Page\Backend\Crud;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface IndexPageInterface extends SymfonyPageInterface
{
    /**
     * @param array $parameters
     *
     * @return bool
     */
    public function isSingleResourceOnPage(array $parameters);

    /**
     * @param array  $parameters
     * @param string $element
     *
     * @return bool
     */
    public function isSingleResourceWithSpecificElementOnPage(array $parameters, $element);

    /**
     * @param string $columnName
     *
     * @return array
     */
    public function getColumnFields($columnName);

    /**
     * @param string $fieldName
     */
    public function sortBy($fieldName);

    /**
     * @param array $parameters
     *
     * @return bool
     */
    public function deleteResourceOnPage(array $parameters);

    /**
     * @param array $parameters
     *
     * @return NodeElement
     */
    public function getActionsForResource(array $parameters);

    public function checkResourceOnPage(array $parameters): void;

    /**
     * @return int
     */
    public function countItems();

    public function filter();

    public function bulkDelete(): void;
}
