<?php

/*
 * This file is part of Jedisjeux.
 *
 * (c) Loïc Frémont
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Page\Backend\Address;

use App\Behat\Page\Backend\Crud\CreatePage as BaseCreatePage;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class CreatePage extends BaseCreatePage
{
    /**
     * @param string $street
     */
    public function specifyStreet($street)
    {
        $this->getElement('street')->setValue($street);
    }

    /**
     * @param string $postcode
     */
    public function specifyPostcode($postcode)
    {
        $this->getElement('postcode')->setValue($postcode);
    }

    /**
     * @param string $city
     */
    public function specifyCity($city)
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
