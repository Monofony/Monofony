<?php



namespace App\Tests\Behat\Service\Resolver;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface CurrentPageResolverInterface
{
    /**
     * @param SymfonyPageInterface[] $pages
     *
     * @return SymfonyPageInterface
     */
    public function getCurrentPageWithForm(array $pages);
}
