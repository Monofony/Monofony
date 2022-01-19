<?php

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Tests\Controller\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

final class RegisterAppUserApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_does_not_allow_to_register_an_app_user_without_required_data()
    {
        $this->client->request('POST', '/api/customers', [], [], ['CONTENT_TYPE' => 'application/json'], '{}');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/register_validation_response', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_register_a_too_short_password()
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

    /**
     * @test
     */
    public function it_does_not_allow_to_register_an_already_registered_user()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');

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

    /**
     * @test
     */
    public function it_allows_to_register_an_app_user()
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
