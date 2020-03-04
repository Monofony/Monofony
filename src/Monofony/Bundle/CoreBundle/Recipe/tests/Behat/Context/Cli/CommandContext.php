<?php

namespace App\Tests\Behat\Context\Cli;

use Webmozart\Assert\Assert;

class CommandContext extends DefaultContext
{
    /**
     * @Then the command should finish successfully
     */
    public function commandSuccess(): void
    {
        Assert::same($this->getTester()->getStatusCode(), 0);
    }

    /**
     * @Then I should see output :text
     */
    public function iShouldSeeOutput($text): void
    {
        Assert::contains($this->getTester()->getDisplay(), $text);
    }
}
