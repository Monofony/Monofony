<?php



namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\NotificationType;
use App\Tests\Behat\Service\NotificationCheckerInterface;
use Behat\Behat\Context\Context;

final class NotificationContext implements Context
{
    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;

    /**
     * @param NotificationCheckerInterface $notificationChecker
     */
    public function __construct(NotificationCheckerInterface $notificationChecker)
    {
        $this->notificationChecker = $notificationChecker;
    }

    /**
     * @Then I should be notified that it has been successfully created
     */
    public function iShouldBeNotifiedItHasBeenSuccessfullyCreated(): void
    {
        $this->notificationChecker->checkNotification('has been successfully created.', NotificationType::success());
    }

    /**
     * @Then I should be notified that it has been successfully edited
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyEdited(): void
    {
        $this->notificationChecker->checkNotification('has been successfully updated.', NotificationType::success());
    }

    /**
     * @Then I should be notified that it has been successfully deleted
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyDeleted(): void
    {
        $this->notificationChecker->checkNotification('has been successfully deleted.', NotificationType::success());
    }

    /**
     * @Then I should be notified that they have been successfully deleted
     */
    public function iShouldBeNotifiedThatTheyHaveBeenSuccessfullyDeleted(): void
    {
        $this->notificationChecker->checkNotification('have been successfully deleted.', NotificationType::success());
    }
}
