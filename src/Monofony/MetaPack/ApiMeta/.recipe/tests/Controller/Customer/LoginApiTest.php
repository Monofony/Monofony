<?php

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Story\TestAppUsersStory;
use App\Tests\Controller\AuthorizedHeaderTrait;
use App\Tests\Controller\JsonApiTestCase;
use App\Tests\Controller\PurgeDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;

class LoginApiTest extends JsonApiTestCase
{
    use AuthorizedHeaderTrait;
    use Factories;
    use PurgeDatabaseTrait;

    /** @test */
    public function it_provides_an_access_token(): void
    {
        TestAppUsersStory::load();

        $data =
            <<<EOT
        {
            "username": "api@sylius.com",
            "password": "sylius"
        }
EOT;

        $this->client->request('POST', '/api/authentication_token', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/new_access_token', Response::HTTP_OK);
    }
}
