<?php

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Tests\Controller\AuthorizedHeaderTrait;
use App\Tests\Controller\JsonApiTestCase;
use Sylius\Component\Customer\Model\CustomerInterface;
use Symfony\Component\HttpFoundation\Response;

final class GetUserProfileApiTest extends JsonApiTestCase
{
    use AuthorizedHeaderTrait;

    /**
     * @test
     */
    public function it_does_not_allow_to_get_user_profile_for_non_authenticated_user()
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['customer'];

        $this->client->request('GET', '/api/customers/'.$customer->getId());

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function it_does_not_allows_to_get_another_profile()
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['another_customer'];

        $this->client->request('GET', '/api/customers/'.$customer->getId(), [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     */
    public function it_allows_to_get_user_profile_when_it_is_myself()
    {
        $resources = $this->loadFixturesFromFile('resources/fixtures.yaml');
        /** @var CustomerInterface $customer */
        $customer = $resources['customer'];

        $this->client->request('GET', '/api/customers/'.$customer->getId(), [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/get_user_profile_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_allows_to_get_my_user_profile()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');

        $this->client->request('GET', '/api/customers/me', [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/get_user_profile_response', Response::HTTP_OK);
    }
}
