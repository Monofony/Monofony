<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Context\Ui\Frontend;

use App\Tests\Behat\Page\Frontend\HomePage;
use Behat\Behat\Context\Context;

class HomepageContext implements Context
{
    /**
     * @var HomePage
     */
    private $homePage;

    /**
     * @param HomePage $homePage
     */
    public function __construct(HomePage $homePage)
    {
        $this->homePage = $homePage;
    }
}
