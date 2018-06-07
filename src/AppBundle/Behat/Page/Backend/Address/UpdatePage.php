<?php

/*
 * This file is part of Jedisjeux.
 *
 * (c) Loïc Frémont
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Page\Backend\Address;

use AppBundle\Behat\Page\Backend\Crud\UpdatePage as BaseUpdatePage;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class UpdatePage extends BaseUpdatePage
{
    /**
     * @param string $street
     */
    public function changeStreet($street)
    {
        $this->getElement('street')->setValue($street);
    }

    /**
     * @param string $postcode
     */
    public function changePostcode($postcode)
    {
        $this->getElement('postcode')->setValue($postcode);
    }

    /**
     * @param string $city
     */
    public function changeCity($city)
    {
        $this->getElement('city')->setValue($city);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'street' => '#app_address_street',
            'postcode' => '#app_address_postcode',
            'city' => '#app_address_city',
        ]);
    }
}
