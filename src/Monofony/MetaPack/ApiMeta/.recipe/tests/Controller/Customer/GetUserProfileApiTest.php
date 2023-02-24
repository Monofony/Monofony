<?php

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Factory\AppUserFactory;
use App\Story\TestAppUsersStory;
use App\Tests\Controller\AuthorizedHeaderTrait;
use App\Tests\Controller\JsonApiTestCase;
use App\Tests\Controller\PurgeDatabaseTrait;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;

final class GetUserProfileApiTest extends JsonApiTestCase
{
    use AuthorizedHeaderTrait;
    use Factories;
    use PurgeDatabaseTrait;

    /** @test */
    public function it_does_not_allow_to_get_user_profile_for_non_authenticated_user(): void
    {
        TestAppUsersStory::load();

        $customer = AppUserFactory::find(['username' => 'sylius'])->getCustomer();

        $this->client->request('GET', '/api/customers/'.$customer->getId());

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_does_not_allows_to_get_another_profile(): void
    {
        TestAppUsersStory::load();

        $customer = AppUserFactory::find(['username' => 'monofony'])->getCustomer();

        $this->client->request('GET', '/api/customers/'.$customer->getId(), [], [], self::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_allows_to_get_user_profile_when_it_is_myself(): void
    {
        TestAppUsersStory::load();

        $customer = AppUserFactory::find(['username' => 'sylius'])->getCustomer();

        $this->client->request('GET', '/api/customers/'.$customer->getId(), [], [], static::$authorizedHeaderWithContentType);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/get_user_profile_response', Response::HTTP_OK);
    }
}
