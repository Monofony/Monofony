<?php



namespace App\Tests\Behat\Page\Backend\Crud;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Session;
use Symfony\Component\Routing\RouterInterface;

class CreatePage extends SymfonyPage
{
    /**
     * @var string
     */
    private $routeName;

    public function __construct(Session $session, \ArrayAccess $minkParameters, RouterInterface $router, $routeName)
    {
        parent::__construct($session, $minkParameters, $router);

        $this->routeName = $routeName;
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
    public function getValidationMessage($element): string
    {
        $foundElement = $this->getFieldElement($element);
        if (null === $foundElement) {
            throw new ElementNotFoundException($this->getSession(), 'Field element');
        }

        $validationMessage = $foundElement->find('css', '.sylius-validation-error');
        if (null === $validationMessage) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $validationMessage->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return $this->routeName;
    }

    /**
     * @param string $element
     *
     * @return \Behat\Mink\Element\NodeElement|null
     *
     * @throws ElementNotFoundException
     */
    private function getFieldElement($element)
    {
        $element = $this->getElement($element);
        while (null !== $element && !$element->hasClass('field')) {
            $element = $element->getParent();
        }

        return $element;
    }
}
