<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Monofony\Bridge\Behat\Crud;

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Session;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractCreatePage extends SymfonyPage implements CreatePageInterface
{
    public function __construct(Session $session, \ArrayAccess $minkParameters, RouterInterface $router)
    {
        parent::__construct($session, $minkParameters, $router);
    }

    /**
     * {@inheritdoc}
     */
    public function create(): void
    {
        $this->getDocument()->pressButton('Create');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationMessage(string $element): string
    {
        $foundElement = $this->getFieldElement($element);

        $validationMessage = $foundElement->find('css', '.sylius-validation-error');
        if (null === $validationMessage) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $validationMessage->getText();
    }

    /**
     * @throws ElementNotFoundException
     */
    private function getFieldElement(string $element): NodeElement
    {
        $element = $this->getElement($element);
        while (!$element->hasClass('field')) {
            $element = $element->getParent();
        }

        return $element;
    }
}
