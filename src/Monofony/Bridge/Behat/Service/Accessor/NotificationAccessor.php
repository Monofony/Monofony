<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Monofony\Bridge\Behat\Service\Accessor;

use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Session;

final class NotificationAccessor implements NotificationAccessorInterface
{
    public function __construct(private Session $session)
    {
    }

    public function getMessageElements(): array
    {
        $messageElements = $this->session->getPage()->findAll('css', '.sylius-flash-message');

        if (empty($messageElements)) {
            throw new ElementNotFoundException($this->session->getDriver(), 'message element', 'css', '.sylius-flash-message');
        }

        return $messageElements;
    }
}
