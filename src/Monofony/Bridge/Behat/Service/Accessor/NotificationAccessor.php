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

use Monofony\Bridge\Behat\NotificationType;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Session;

final class NotificationAccessor implements NotificationAccessorInterface
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->getMessageElement()->getText();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        if (
            $this->getMessageElement()->hasClass('positive')
            || $this->getMessageElement()->hasClass('success')
        ) {
            return NotificationType::success();
        }

        if (
            $this->getMessageElement()->hasClass('negative')
            || $this->getMessageElement()->hasClass('alert')
        ) {
            return NotificationType::failure();
        }

        throw new \RuntimeException('Cannot resolve notification type');
    }

    /**
     * @return NodeElement
     *
     * @throws ElementNotFoundException
     */
    private function getMessageElement()
    {
        $messageElement = $this->session->getPage()->find('css', '.sylius-flash-message');

        if (null === $messageElement) {
            throw new ElementNotFoundException($this->session->getDriver(), 'message element', 'css', '.sylius-flash-message');
        }

        return $messageElement;
    }
}
