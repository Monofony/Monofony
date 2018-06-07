<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Page\Backend\Crud;

use AppBundle\Behat\Page\SymfonyPageInterface;
use Behat\Mink\Exception\ElementNotFoundException;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
interface UpdatePageInterface extends SymfonyPageInterface
{
    /**
     * @param string $element
     *
     * @return string
     *
     * @throws ElementNotFoundException
     */
    public function getValidationMessage($element);

    /**
     * @param array $parameters where keys are some of arbitrary elements defined by user and values are expected values
     *
     * @return bool
     */
    public function hasResourceValues(array $parameters);

    public function saveChanges();
}
