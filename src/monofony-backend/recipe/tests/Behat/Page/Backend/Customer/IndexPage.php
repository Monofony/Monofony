<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Customer;

use App\Tests\Behat\Page\Backend\Crud\IndexPage as BaseIndexPage;
use App\Entity\Customer\CustomerInterface;

class IndexPage extends BaseIndexPage
{
    /**
     * {@inheritdoc}
     */
    public function getCustomerAccountStatus(CustomerInterface $customer): string
    {
        $tableAccessor = $this->getTableAccessor();
        $table = $this->getElement('table');

        $row = $tableAccessor->getRowWithFields($table, ['email' => $customer->getEmail()]);

        return $tableAccessor->getFieldFromRow($table, $row, 'enabled')->getText();
    }
}
