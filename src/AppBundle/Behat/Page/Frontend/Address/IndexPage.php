<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Page\Frontend\Address;

use AppBundle\Behat\Page\SymfonyPage;

class IndexPage extends SymfonyPage
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName()
    {
        return 'app_frontend_address_index';
    }

    /**
     * @param string $title
     *
     * @return bool
     */
    public function isAddressOnList($title)
    {
        return null !== $this->getDocument()->find('css', sprintf('#address-list address:contains("%s")', $title));
    }
}
