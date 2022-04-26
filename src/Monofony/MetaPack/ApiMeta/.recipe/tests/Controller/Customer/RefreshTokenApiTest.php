<?php

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Story\TestAppUsersStory;
use App\Tests\Controller\AuthorizedHeaderTrait;
use App\Tests\Controller\JsonApiTestCase;
use App\Tests\Controller\PurgeDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;

class RefreshTokenApiTest extends JsonApiTestCase
{
    use AuthorizedHeaderTrait;
    use Factories;
    use PurgeDatabaseTrait;

    /** @test */
    public function it_allows_to_refresh_an_access_token(): void
    {
        TestAppUsersStory::load();

        $refreshToken = $this->getRefreshToken();

        $data =
            <<<EOT
        {
            "refresh_token": "$refreshToken"
        }
EOT;

        $this->client->request('POST', '/api/token/refresh', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/new_access_token', Response::HTTP_OK);
    }

    private function getRefreshToken(): string
    {
        $data =
            <<<EOT
        {
            "username": "api@sylius.com",
            "password": "sylius"
        }
EOT;

        $this->client->request('POST', '/api/authentication_token', [], [], ['CONTENT_TYPE' => 'application/json'], $data);
        $response = $this->client->getResponse();

        $refreshToken = \json_decode($response->getContent(), true)['refresh_token'] ?: null;

        $this->assertNotNull($refreshToken, 'Refresh token was not found but it should.');

        return $refreshToken;
    }
}
