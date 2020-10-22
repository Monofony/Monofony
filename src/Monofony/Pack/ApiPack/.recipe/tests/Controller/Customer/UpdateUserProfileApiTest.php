<?php

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Tests\Controller\AuthorizedHeaderTrait;
use App\Tests\Controller\JsonApiTestCase;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\HttpFoundation\Response;

final class UpdateUserProfileApiTest extends JsonApiTestCase
{
    use AuthorizedHeaderTrait;

    /**
     * @test
     */
    public function it_does_not_allow_to_update_user_profile_for_non_authenticated_user()
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['customer'];

        $this->client->request('PUT', '/api/customers/'.$customer->getId());

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allows_to_update_another_profile()
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['another_customer'];

        $data =
            <<<EOT
        {
            "email": "inigo.montoya@prepare-to-die.com",
            "firstName": "Inigo",
            "lastName": "Montoya",
            "subscribedToNewsletter": true
        }
EOT;

        $this->client->request('PUT', '/api/customers/'.$customer->getId(), [], [], static::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     */
    public function it_allows_to_update_user_profile()
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['customer'];

        $data =
            <<<EOT
        {
            "email": "inigo.montoya@prepare-to-die.com",
            "firstName": "Inigo",
            "lastName": "Montoya",
            "subscribedToNewsletter": true
        }
EOT;

        $this->client->request('PUT', '/api/customers/'.$customer->getId(), [], [], static::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/update_user_profile_response', Response::HTTP_OK);

        $this->assertLoginWithCredentials('inigo.montoya@prepare-to-die.com', 'sylius');
    }

    private function assertLoginWithCredentials($username, $password): void
    {
        $data =
            <<<EOT
        {
            "client_id": "client_id",
            "client_secret": "secret",
            "grant_type": "password",
            "username": "$username",
            "password": "$password"
        }
EOT;

        $this->client->request('POST', '/api/oauth/v2/token', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/new_access_token', Response::HTTP_OK);
    }
}
