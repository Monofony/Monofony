<?php

/*
 * This file is part of mz_149_s_fertitest.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Controller\Customer;

use App\Tests\Controller\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_provides_an_access_token()
    {
        $this->loadFixturesFromFile('authentication/api_user.yml');

        $data =
            <<<EOT
        {
            "client_id": "client_id",
            "client_secret": "secret",
            "grant_type": "password",
            "username": "api@sylius.com",
            "password": "sylius"
        }
EOT;

        $this->client->request('POST', '/api/oauth/v2/token', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/new_access_token', Response::HTTP_OK);
    }

}
