<?php
/**
 * Created by PhpStorm.
 * User: pbrun
 * Date: 21/04/15
 * Time: 10:48
 */

namespace AppBundle\Behat;

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementHtmlException;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\ExpectationException;

/**
 * Class UtilsContext
 * @package AppBundle\Behat
 */
class UtilsContext extends DefaultContext
{
    /**
     * @When /^I wait until loading has finished$/
     */
    public function waitUntilLoadingHasFinished()
    {
        $this->getSession()->wait(5000, "$('.spinner').is('visible')");
        $this->getSession()->wait(5000, "$('.spinner').not('visible')");
    }

    /**
     * @When /^I wait until modal is visible$/
     */
    public function waitUntilModalIsVisible()
    {
        $this->getSession()->wait(2000, "$('.modal.active').is('visible')");
    }

    /**
     * @When /^I press confirm button$/
     */
    public function iPressConfirmButton()
    {
        $id = 'confirmation-button';
        $button = $this->getSession()->getPage()->findById($id);

        if (null === $button) {
            throw new ElementNotFoundException($this->getSession(), 'div', 'id', $id);
        }

        $button->press();
    }

    /**
     * @When /^I press create button$/
     */
    public function iPressCreateButton()
    {
        $class = 'plus icon';
        $button = $this->getSession()->getPage()->find('named', array('i', $class));

        if (null === $button) {
            throw new ElementNotFoundException($this->getSession(), 'span', 'class', $class);
        }

        $button->press();
    }

    /**
     * @When /^I wait "([^""]*)" seconds$/
     *
     * @param integer $time
     */
    public function waitTime($time)
    {
        $this->getSession()->wait($time * 1000);
    }

    /**
     * @When /^I wait "([^""]*)" seconds until "([^""]*)"$/
     *
     * @param integer $time time in milliseconds
     * @param string $condition JS condition
     */
    public function waitTimeUntilCondition($time, $condition)
    {
        $this->getSession()->wait($time * 1000, $condition);
    }

    /**
     * @When /^I attach file "([^""]*)" to "([^""]*)"$/
     *
     * @param string $path path to file
     * @param string $locator input id, name or label
     *
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function attachFile($path, $locator)
    {
        $path = realpath($this->getContainer()->getParameter('kernel.root_dir') . "/../" . $path);
        $page = $this->getSession()->getPage();
        $page->attachFileToField($locator, $path);
    }

    /**
     * @When /^I check the "([^"]*)" radio button$/
     */
    public function iCheckTheRadioButton($labelText)
    {
        $page = $this->getSession()->getPage();

        foreach ($page->findAll('css', 'label') as $label) {
            if ($labelText === $label->getText()) {
                $label->click();

                return;
            }
        }

        throw new \Exception("Radio button with label {$labelText} not found");
    }

    /**
     * @When /^(?:|I )press "(?P<button>(?:[^"]|\\")*)" on "([^"]*)"$/
     *
     * @param $button
     * @param $element
     * @throws ElementNotFoundException
     */
    public function IPressButtonOnElement($button, $element)
    {
        $button = $this->fixStepArgument($button);
        $element = $this->fixStepArgument($element);
        $page = $this->getSession()->getPage();

        $nodeElement = $page->find('css', $element);

        if (null === $nodeElement) {
            throw new \LogicException('Could not find the element with css "' . $element . '"');
        }

        $nodeElement->pressButton($button);
    }

    /**
     * @When /^(?:|I )follow "(?P<link>(?:[^"]|\\")*)" on "([^"]*)"$/
     *
     * @param $link
     * @param $element
     * @throws ElementNotFoundException
     */
    public function IFollowLinkOnElement($link, $element)
    {
        $link = $this->fixStepArgument($link);
        $element = $this->fixStepArgument($element);
        $page = $this->getSession()->getPage();

        $nodeElement = $page->find('css', $element);

        if (null === $nodeElement) {
            throw new \LogicException('Could not find the element with css "' . $element . '"');
        }

        $nodeElement->clickLink($link);
    }

    /**
     * @When /^(?:|I )should see "([^"]*)" element$/
     *
     * @param $element
     * @throws ElementHtmlException
     */
    public function IShouldSeeElement($element)
    {
        $element = $this->fixStepArgument($element);
        $nodeElement = $this->assertSession()->elementExists('css', $element);
        if (false === $nodeElement->isVisible()) {
            $message = sprintf('element with css "%s" is not visible, but it should', $element);
            throw new ElementHtmlException($message, $this->getSession(), $nodeElement);
        }
    }

    /**
     * @When /^(?:|I )should not see "([^"]*)" element$/
     *
     * @param $element
     * @throws ElementHtmlException
     */
    public function IShouldNotSeeElement($element)
    {
        $element = $this->fixStepArgument($element);
        try {
            $nodeElement = $this->assertSession()->elementExists('css', $element);
            if (true === $nodeElement->isVisible()) {
                $message = sprintf('element with css "%s" is not visible, but it should', $element);
                throw new ElementHtmlException($message, $this->getSession(), $nodeElement);
            }
        } catch (ElementNotFoundException $e) {
            $this->assertSession()->elementNotExists('css', $element);
        }
    }

    /**
     * @When /^(?:|I )should have value "([^"]*)" on "([^"]*)" element$/
     *
     * @param $element
     * @throws ElementHtmlException
     */
    public function IShoudHaveValueOnElement($value, $element)
    {
        $element = $this->fixStepArgument($element);
        $nodeElement = $this->assertSession()->elementExists('css', $element);

        if (false === $nodeElement->hasAttribute('value') or $value !== $nodeElement->getAttribute('value')) {
            $message = sprintf('"%s" element has value "%s" but it should have value "%s"', $element, $nodeElement->getAttribute('value'), $value);
            throw new ElementHtmlException($message, $this->getSession(), $nodeElement);
        }
    }

    /**
     * @When /^(?:|I )should not have value "([^"]*)" on "([^"]*)" element$/
     *
     * @param $element
     * @throws ElementHtmlException
     */
    public function IShoudNotHaveValueOnElement($value, $element)
    {
        $element = $this->fixStepArgument($element);
        $nodeElement = $this->assertSession()->elementExists('css', $element);

        if ($value === $nodeElement->getAttribute('value')) {
            $message = sprintf('"%s" element has value "%s" but it should not', $element, $value);
            throw new ElementHtmlException($message, $this->getSession(), $nodeElement);
        }
    }

    /**
     * Checks checkbox in multiple select field with specified id|name|label|value.
     *
     * @When /^I (?:|additionally )check "([^""]*)" from multiple select "([^""]*)"$/
     */
    public function checkFromMultipleSelect($option, $select)
    {
        $select = $this->fixStepArgument($select);
        $page = $this->getSession()->getPage();
        $select = $page->findField($select);
        $parent = $select->getParent();

        /** @var NodeElement $button */
        $button = $parent->find('css', '.ms-choice');
        if (null === $button) {
            throw new \LogicException('Could not find the button element with class "ms-choice"');
        }

        /* open the list */
        $button->press();

        /** @var NodeElement $list */
        $list = $parent->find('css', '.ms-drop');

        if (null === $list) {
            throw new \LogicException('Could not find the element with class "ms-drop"');
        }

        $list->checkField($option);

        /* close the list */
        $button->press();
    }

    /**
     * @When /^(?:|I )should have option "([^"]*)" selected on "([^"]*)"/
     *
     * @param $optionValue
     * @param $select
     * @throws ElementHtmlException
     */
    public function IShoudHaveOptionSelectedOnElement($optionValue, $select)
    {
        $selectName = $select;
        $select = $this->fixStepArgument($select);
        $page = $this->getSession()->getPage();
        $select = $page->findField($select);

        /** @var NodeElement $list */
        $options = $select->findAll('css', 'option');

        /** @var NodeElement $option */
        foreach ($options as $option) {
            if ($optionValue === $option->getHtml()) {
                if ('selected' !== $option->getAttribute('selected') and "" !== $option->getAttribute('value')) {
                    $message = sprintf('"%s" option from "%s" is not selected but it should', $optionValue, $selectName);
                    throw new ElementHtmlException($message, $this->getSession(), $select);
                }
            } elseif ('selected' === $option->getAttribute('selected')) {
                $message = sprintf('"%s" option from "%s" is selected but it should not', $optionValue, $selectName);
                throw new ElementHtmlException($message, $this->getSession(), $select);
            }
        }
    }

    /**
     * @Then /^I fill in wysiwyg field "([^"]*)" with "([^"]*)"$/
     */
    public function iFillInWysiwygOnFieldWith($element, $value)
    {
        $element = $this->fixStepArgument($element);
        $page = $this->getSession()->getPage();
        $field = $page->findField($element);

        if (empty($field)) {
            throw new ExpectationException('Could not find WYSIWYG with locator: ' . $element, $this->getSession());
        }

        $fieldId = $field->getAttribute('id');

        if (empty($fieldId)) {
            throw new ExpectationException('Could not find an id for field with locator: ' . $element, $this->getSession());
        }

        $this->getSession()->executeScript("CKEDITOR.instances[\"$fieldId\"].setData(\"$value\");");
    }
}