<?php

/*
 * This file is part of Jedisjeux.
 *
 * (c) Loïc Frémont
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Context\Ui\Backend;

use AppBundle\Behat\Page\Backend\Address\IndexPage;
use AppBundle\Behat\Page\Backend\Address\UpdatePage;
use AppBundle\Behat\Page\Backend\Address\CreatePage;
use AppBundle\Behat\Page\UnexpectedPageException;
use AppBundle\Behat\Service\Resolver\CurrentPageResolverInterface;
use AppBundle\Entity\Address;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class ManagingAddressesContext implements Context
{
    /**
     * @var IndexPage
     */
    private $indexPage;

    /**
     * @var CreatePage
     */
    private $createPage;

    /**
     * @var UpdatePage
     */
    private $updatePage;

    /**
     * @var CurrentPageResolverInterface
     */
    private $currentPageResolver;

    /**
     * ManagingPeopleContext constructor.
     *
     * @param IndexPage $indexPage
     * @param CreatePage $createPage
     * @param UpdatePage $updatePage
     * @param CurrentPageResolverInterface $currentPageResolver
     */
    public function __construct(
        IndexPage $indexPage,
        CreatePage $createPage,
        UpdatePage $updatePage,
        CurrentPageResolverInterface $currentPageResolver)
    {
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
        $this->currentPageResolver = $currentPageResolver;
    }

    /**
     * @Given I want to create a new address
     */
    public function iWantToCreateANewAddress()
    {
        $this->createPage->open();
    }

    /**
     * @When I want to browse addresses
     */
    public function iWantToBrowseAddress()
    {
        $this->indexPage->open();
    }

    /**
     * @Given I want to edit :address address
     */
    public function iWantToEditTheAddress(Address $address)
    {
        $this->updatePage->open(['id' => $address->getId()]);
    }

    /**
     * @When /^I specify its street as "([^"]*)"$/
     * @When I do not specify its street
     */
    public function iSpecifyItsStreetAs($street = null)
    {
        $this->createPage->specifyStreet($street);
    }

    /**
     * @When /^I specify its postcode as "([^"]*)"$/
     * @When I do not specify its postcode
     */
    public function iSpecifyItsPostcodeAs($postcode = null)
    {
        $this->createPage->specifyPostcode($postcode);
    }

    /**
     * @When /^I specify its city as "([^"]*)"$/
     * @When I do not specify its city
     */
    public function iSpecifyItsCityAs($city = null)
    {
        $this->createPage->specifyCity($city);
    }

    /**
     * @When I change its title as :title
     */
    public function iChangeItsTitleAs($title)
    {
        $this->updatePage->changeStreet($title);
    }

    /**
     * @When I add it
     * @When I try to add it
     */
    public function iAddIt()
    {
        $this->createPage->create();
    }

    /**
     * @When I save my changes
     */
    public function iSaveMyChanges()
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @When I delete address with street :street
     */
    public function iDeleteAddressWithTitle($street)
    {
        $this->indexPage->deleteResourceOnPage(['street' => $street]);
    }

    /**
     * @Then I should be notified that the street is required
     */
    public function iShouldBeNotifiedThatStreetIsRequired()
    {
        Assert::same($this->createPage->getValidationMessage('street'), 'This value should not be blank.');
    }

    /**
     * @Then /^there should be (\d+) addresses in the list$/
     */
    public function iShouldSeeAddressesInTheList($number)
    {
        Assert::same($this->indexPage->countItems(), (int)$number);
    }

    /**
     * @Then this address should not be added
     */
    public function thisAddressShouldNotBeAdded()
    {
        $this->indexPage->open();

        Assert::same($this->indexPage->countItems(), 0);
    }

    /**
     * @Then the address :address should appear in the website
     * @Then I should see the address :address in the list
     */
    public function theAddressShould(Address $address)
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['street' => $address->getStreet()]));
    }

    /**
     * @Then this address with street :street should appear in the website
     */
    public function thisAddressWithTitleShouldAppearInTheStore($street)
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['street' => $street]));
    }

    /**
     * @Then there should not be :street address anymore
     */
    public function thereShouldBeNoAnymore($street)
    {
        Assert::false($this->indexPage->isSingleResourceOnPage(['street' => $street]));
    }

    /**
     * @Then I should not be able to browse addresses
     */
    public function iShouldNotBeAbleToBrowseAddresses()
    {
        try {
            $this->indexPage->open();

        } catch (UnexpectedPageException $exception) {
            // nothing else to do
        }

        Assert::false($this->indexPage->isOpen());
    }
}
