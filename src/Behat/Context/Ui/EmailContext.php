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

namespace App\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use App\Behat\Service\SharedStorageInterface;
use App\Behat\Service\EmailCheckerInterface;
use Webmozart\Assert\Assert;

final class EmailContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var EmailCheckerInterface
     */
    private $emailChecker;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param EmailCheckerInterface  $emailChecker
     */
    public function __construct(SharedStorageInterface $sharedStorage, EmailCheckerInterface $emailChecker)
    {
        $this->sharedStorage = $sharedStorage;
        $this->emailChecker = $emailChecker;
    }

    /**
     * @Then it should be sent to :recipient
     * @Then the email with reset token should be sent to :recipient
     * @Then the email with contact request should be sent to :recipient
     */
    public function anEmailShouldBeSentTo($recipient)
    {
        Assert::true($this->emailChecker->hasRecipient($recipient));
    }

    /**
     * @Then :count email(s) should be sent to :recipient
     */
    public function numberOfEmailsShouldBeSentTo($count, $recipient)
    {
        Assert::same($this->emailChecker->countMessagesTo($recipient), (int) $count);
    }

    /**
     * @Then an email to verify your email validity should have been sent to :recipient
     */
    public function anEmailToVerifyYourEmailValidityShouldHaveBeenSentTo($recipient)
    {
        $this->assertEmailContainsMessageTo('To verify your email address', $recipient);
    }

    /**
     * @Then a welcoming email should have been sent to :recipient
     */
    public function aWelcomingEmailShouldHaveBeenSentTo($recipient)
    {
        $this->assertEmailContainsMessageTo('Welcome to our website', $recipient);
    }

    /**
     * @param string $message
     * @param string $recipient
     */
    private function assertEmailContainsMessageTo($message, $recipient)
    {
        Assert::true($this->emailChecker->hasMessageTo($message, $recipient));
    }
}
