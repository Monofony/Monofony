<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Service\Resolver;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;
use Behat\Mink\Session;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Webmozart\Assert\Assert;

final class CurrentPageResolver implements CurrentPageResolverInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var UrlMatcherInterface
     */
    private $urlMatcher;

    /**
     * @param Session             $session
     * @param UrlMatcherInterface $urlMatcher
     */
    public function __construct(Session $session, UrlMatcherInterface $urlMatcher)
    {
        $this->session = $session;
        $this->urlMatcher = $urlMatcher;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException
     */
    public function getCurrentPageWithForm(array $pages)
    {
        $routeParameters = $this->urlMatcher->match(parse_url($this->session->getCurrentUrl(), PHP_URL_PATH));

        Assert::allIsInstanceOf($pages, SymfonyPageInterface::class);

        foreach ($pages as $page) {
            if ($routeParameters['_route'] === $page->getRouteName()) {
                return $page;
            }
        }

        throw new \LogicException('Route name could not be matched to provided pages.');
    }
}
