<?php

/*
 * This file is part of Capsolo.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Entity\User\AppUser;
use App\Tests\Controller\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_does_not_allow_to_reset_password_without_required_data()
    {
        $data =
            <<<EOT
        {
            "email": ""
        }
EOT;

        $this->client->request('POST', '/api/request_password', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'customer/request_password_validation_response', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @test
     */
    public function it_allows_to_request_new_password()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');

        $data =
            <<<EOT
        {
            "email": "api@sylius.com"
        }
EOT;

        $this->client->request('POST', '/api/request_password', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertEquals($response->getStatusCode(), Response::HTTP_NO_CONTENT);
    }
}
