<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Customer;

use Monofony\Bridge\Behat\Crud\AbstractIndexPage;
use Monofony\Bridge\Behat\Crud\IndexPageInterface;
use Monofony\Contracts\Core\Model\Customer\CustomerInterface;

class IndexPage extends AbstractIndexPage implements IndexPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'sylius_backend_customer_index';
    }

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
