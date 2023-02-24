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

class ChangePasswordApiTest extends JsonApiTestCase
{
    use Factories;
    use AuthorizedHeaderTrait;
    use PurgeDatabaseTrait;

    /** @test */
    public function it_does_not_allow_to_change_password_for_non_authenticated_user(): void
    {
        TestAppUsersStory::load();

        $customer = AppUserFactory::find(['username' => 'sylius'])->getCustomer();

        $this->client->request('PATCH', '/api/customers/'.$customer->getId().'/password', [], [], ['CONTENT_TYPE' => 'application/merge-patch+json'], '{}');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/access_denied_response', Response::HTTP_UNAUTHORIZED);
    }

    /** @test */
    public function it_does_not_allow_to_change_password_without_required_data(): void
    {
        TestAppUsersStory::load();

        $customer = AppUserFactory::find(['username' => 'sylius'])->getCustomer();

        $this->client->request('PATCH', '/api/customers/'.$customer->getId().'/password', [], [], self::$authorizedHeaderForPatch, '{}');

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/change_password_validation_response', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_does_not_allow_to_change_password_with_wrong_current_password(): void
    {
        TestAppUsersStory::load();

        $customer = AppUserFactory::find(['username' => 'sylius'])->getCustomer();

        $data =
            <<<EOT
        {
            "currentPassword": "wrong_password",
            "newPassword": "monofony"
        }
EOT;

        $this->client->request('PATCH', '/api/customers/'.$customer->getId().'/password', [], [], self::$authorizedHeaderForPatch, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/wrong_current_password_validation_response', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_allows_to_change_password(): void
    {
        TestAppUsersStory::load();

        $customer = AppUserFactory::find(['username' => 'sylius'])->getCustomer();

        $data =
            <<<EOT
        {
            "currentPassword": "sylius",
            "newPassword": "monofony"
        }
EOT;

        $this->client->request('PATCH', '/api/customers/'.$customer->getId().'/password', [], [], self::$authorizedHeaderForPatch, $data);

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
