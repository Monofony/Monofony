<?php

namespace App\Tests\Behat\Context\Transform;

use App\Formatter\StringInflector;
use Behat\Behat\Context\Context;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\SharedStorageInterface;

final class SharedStorageContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @param SharedStorageInterface $sharedStorage
     */
    public function __construct(SharedStorageInterface $sharedStorage)
    {
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Transform /^(it|its|theirs|them)$/
     */
    public function getLatestResource()
    {
        return $this->sharedStorage->getLatestResource();
    }

    /**
     * @Transform /^(?:this|that|the) ([^"]+)$/
     */
    public function getResource($resource)
    {
        return $this->sharedStorage->get(StringInflector::nameToCode($resource));
    }
}
