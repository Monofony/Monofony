<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\EmailCheckerInterface;
use Webmozart\Assert\Assert;

final class EmailContext implements Context
{
    public function __construct(
        private EmailCheckerInterface $emailChecker,
    ) {
    }

    /**
     * @Then it should be sent to :recipient
     * @Then the email with reset token should be sent to :recipient
     * @Then the email with contact request should be sent to :recipient
     */
    public function anEmailShouldBeSentTo(string $recipient): void
    {
        Assert::true($this->emailChecker->hasRecipient($recipient));
    }

    /**
     * @Then :count email(s) should be sent to :recipient
     */
    public function numberOfEmailsShouldBeSentTo(int $count, string $recipient): void
    {
        Assert::same($this->emailChecker->countMessagesTo($recipient), $count);
    }

    /**
     * @Then an email to verify your email validity should have been sent to :recipient
     */
    public function anEmailToVerifyYourEmailValidityShouldHaveBeenSentTo(string $recipient): void
    {
        $this->assertEmailContainsMessageTo('To verify your email address', $recipient);
    }

    /**
     * @Then a welcoming email should have been sent to :recipient
     */
    public function aWelcomingEmailShouldHaveBeenSentTo(string $recipient): void
    {
        $this->assertEmailContainsMessageTo('Welcome to our website', $recipient);
    }

    private function assertEmailContainsMessageTo(string $message, string $recipient): void
    {
        Assert::true($this->emailChecker->hasMessageTo($message, $recipient));
    }
}
