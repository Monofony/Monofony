<?php

namespace Monofony\Bundle\AdminBundle\Tests\Behat\Crud;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface IndexPageInterface extends SymfonyPageInterface
{
    public function isSingleResourceOnPage(array $parameters): bool;

    public function isSingleResourceWithSpecificElementOnPage(array $parameters, string $element): bool;

    public function getColumnFields(string $columnName): array;

    public function sortBy(string $fieldName): void;

    public function deleteResourceOnPage(array $parameters): void;

    public function getActionsForResource(array $parameters): NodeElement;

    public function checkResourceOnPage(array $parameters): void;

    public function countItems(): int;

    public function filter(): void;

    public function bulkDelete(): void;
}
