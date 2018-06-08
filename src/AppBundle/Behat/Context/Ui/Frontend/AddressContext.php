<?php

/*
 * This file is part of Jedisjeux.
 *
 * (c) Loïc Frémont
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Context\Ui\Frontend;

use AppBundle\Behat\Page\Frontend\Address\IndexPage;
use AppBundle\Behat\Page\Frontend\Address\ShowPage;
use AppBundle\Behat\Page\UnexpectedPageException;
use AppBundle\Entity\Address;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class AddressContext implements Context
{
    /**
     * @var ShowPage
     */
    private $showPage;

    /**
     * @var IndexPage
     */
    private $indexPage;

    /**
     * @param ShowPage $showPage
     * @param IndexPage $indexPage
     */
    public function __construct(ShowPage $showPage, IndexPage $indexPage)
    {
        $this->showPage = $showPage;
        $this->indexPage = $indexPage;
    }

    /**
     * @When I want to browse addresses
     */
    public function iWantToBrowseAddresses()
    {
        $this->indexPage->open();
    }

    /**
     * @When /^I check (this address)'s details$/
     */
    public function iOpenAddressPage(Address $address)
    {
        $this->showPage->open(['slug' => $address->getSlug()]);
    }

    /**
     * @Then I should see the address :title
     */
    public function iShouldSeeAddress($title)
    {
        Assert::true($this->indexPage->isAddressOnList($title));
    }

    /**
     * @Then I should not see the address :title
     */
    public function iShouldNotSeeAddress($title)
    {
        Assert::false($this->indexPage->isAddressOnList($title));
    }

    /**
     * @Then I should see the address title :title
     */
    public function iShouldSeePersonName($title)
    {
        Assert::same($this->showPage->getTitle(), $title);
    }

    /**
     * @Then /^I should be able to see (this address)'s details$/
     */
    public function iShouldBeAbleToSeeAddressDetails(Address $address)
    {
        try {
            $this->iOpenAddressPage($address);

        } catch (UnexpectedPageException $exception) {
            // nothing else to do
        }

        Assert::true($this->showPage->isOpen(['slug' => $address->getSlug()]));
    }

    /**
     * @Then /^I should not be able to see (this address)'s details$/
     */
    public function iShouldNotBeAbleToSeeAddressDetails(Address $address)
    {
        try {
            $this->iOpenAddressPage($address);

        } catch (UnexpectedPageException $exception) {
            // nothing else to do
        }

        Assert::false($this->showPage->isOpen(['slug' => $address->getSlug()]));
    }
}
