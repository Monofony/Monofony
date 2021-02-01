<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use ApiTestCase\JsonApiTestCase as BaseJsonApiTestCase;

class JsonApiTestCase extends BaseJsonApiTestCase
{
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->dataFixturesPath = __DIR__.'/../DataFixtures/ORM';
        $this->expectedResponsesPath = __DIR__.'/../Responses/Expected';
    }

    /**
     * @before
     */
    public function setUpClient(): void
    {
        $this->client = static::createClient([], ['HTTP_ACCEPT' => 'application/ld+json']);
    }
}
