<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\EmailCheckerInterface;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
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
    public function anEmailShouldBeSentTo($recipient): void
    {
        Assert::true($this->emailChecker->hasRecipient($recipient));
    }

    /**
     * @Then :count email(s) should be sent to :recipient
     */
    public function numberOfEmailsShouldBeSentTo($count, $recipient): void
    {
        Assert::same($this->emailChecker->countMessagesTo($recipient), (int) $count);
    }

    /**
     * @Then an email to verify your email validity should have been sent to :recipient
     */
    public function anEmailToVerifyYourEmailValidityShouldHaveBeenSentTo($recipient): void
    {
        $this->assertEmailContainsMessageTo('To verify your email address', $recipient);
    }

    /**
     * @Then a welcoming email should have been sent to :recipient
     */
    public function aWelcomingEmailShouldHaveBeenSentTo($recipient): void
    {
        $this->assertEmailContainsMessageTo('Welcome to our website', $recipient);
    }

    /**
     * @param string $message
     * @param string $recipient
     */
    private function assertEmailContainsMessageTo($message, $recipient): void
    {
        Assert::true($this->emailChecker->hasMessageTo($message, $recipient));
    }
}
