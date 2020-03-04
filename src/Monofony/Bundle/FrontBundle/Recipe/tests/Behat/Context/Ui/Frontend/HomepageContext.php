<?php

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
