<?php



namespace App\Tests\Behat\Page\Backend\Crud;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use App\Formatter\StringInflector;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Session;
use Symfony\Component\Routing\RouterInterface;

class UpdatePage extends SymfonyPage implements UpdatePageInterface
{
    /** @var string */
    private $routeName;

    public function __construct(Session $session, \ArrayAccess $minkParameters, RouterInterface $router, $routeName)
    {
        parent::__construct($session, $minkParameters, $router);

        $this->routeName = $routeName;
    }

    /**
     * {@inheritdoc}
     */
    public function saveChanges()
    {
        $this->getDocument()->pressButton('sylius_save_changes_button');
    }

    /**
     * {@inheritdoc}
     */
    public function getValidationMessage($element)
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
    public function hasResourceValues(array $parameters)
    {
        foreach ($parameters as $element => $value) {
            if ($this->getElement($element)->getValue() !== (string) $value) {
                return false;
            }
        }

        return true;
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
        $element = $this->getElement(StringInflector::nameToCode($element));
        while (null !== $element && !$element->hasClass('field')) {
            $element = $element->getParent();
        }

        return $element;
    }
}
