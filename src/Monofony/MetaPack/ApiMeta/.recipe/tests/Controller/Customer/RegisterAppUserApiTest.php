<?php

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Story\TestAppUsersStory;
use App\Tests\Controller\AuthorizedHeaderTrait;
use App\Tests\Controller\JsonApiTestCase;
use App\Tests\Controller\PurgeDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;

final class RegisterAppUserApiTest extends JsonApiTestCase
{
    use AuthorizedHeaderTrait;
    use Factories;
    use PurgeDatabaseTrait;

    /** @test */
    public function it_does_not_allow_to_register_an_app_user_without_required_data(): void
    {
        $this->client->request('POST', '/api/customers', [], [], ['CONTENT_TYPE' => 'application/json'], '{}');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/register_validation_response', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_does_not_allow_to_register_a_too_short_password(): void
    {
        $data =
            <<<EOT
        {
            "email": "api@sylius.com",
            "password": "123"
        }
EOT;

        $this->client->request('POST', '/api/customers', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/too_short_password_validation_response', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_does_not_allow_to_register_an_already_registered_user(): void
    {
        TestAppUsersStory::load();

        $data =
            <<<EOT
        {
            "email": "api@sylius.com",
            "password": "p@ssw0rd"
        }
EOT;

        $this->client->request('POST', '/api/customers', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/unique_email_validation_response', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_allows_to_register_an_app_user(): void
    {
        $data =
            <<<EOT
        {
            "email": "anne.onymous@example.com",
            "password": "p@ssw0rd"
        }
EOT;

        $this->client->request('POST', '/api/customers', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
    }
}
