<?php

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Tests\Controller\AuthorizedHeaderTrait;
use App\Tests\Controller\JsonApiTestCase;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\HttpFoundation\Response;

class ChangePasswordApiTest extends JsonApiTestCase
{
    use AuthorizedHeaderTrait;

    /**
     * @test
     */
    public function it_does_not_allow_to_change_password_for_non_authenticated_user(): void
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['customer'];

        $this->client->request('PUT', '/api/customers/'.$customer->getId().'/password', [], [], ['CONTENT_TYPE' => 'application/json'], '{}');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_change_password_without_required_data(): void
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['customer'];

        $this->client->request('PUT', '/api/customers/'.$customer->getId().'/password', [], [], self::$authorizedHeaderWithContentType, '{}');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/change_password_validation_response', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function it_does_not_allow_to_change_password_with_wrong_current_password(): void
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['customer'];

        $data =
            <<<EOT
        {
            "currentPassword": "wrong_password",
            "newPassword": "monofony"
        }
EOT;

        $this->client->request('PUT', '/api/customers/'.$customer->getId().'/password', [], [], self::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/wrong_current_password_validation_response', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function it_allows_to_change_password(): void
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['customer'];

        $data =
            <<<EOT
        {
            "currentPassword": "sylius",
            "newPassword": "monofony"
        }
EOT;

        $this->client->request('PUT', '/api/customers/'.$customer->getId().'/password', [], [], self::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);

        $this->assertLoginWithCredentials($customer->getEmail(), 'monofony');
    }

    private function assertLoginWithCredentials(?string $username, string $password): void
    {
        $data =
            <<<EOT
        {
            "username": "$username",
            "password": "$password"
        }
EOT;

        $this->client->request('POST', '/api/authentication_token', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/new_access_token', Response::HTTP_OK);
    }
}
