<?php

declare(strict_types=1);

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Controller\Customer;

use App\Tests\Controller\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class RefreshTokenApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_allows_to_refresh_an_access_token()
    {
        $this->loadFixturesFromFile('resources/fixtures.yaml');

        $data =
            <<<EOT
        {
            "client_id": "client_id",
            "client_secret": "secret",
            "grant_type": "refresh_token",
            "refresh_token": "SampleRefreshTokenODllODY4ZTQyOThlNWIyMjA1ZDhmZjE1ZDYyMGMwOTUxOWM2NGFmNGRjNjQ2NDBhMDVlNGZjMmQ0YzgyNDM2Ng"
        }
EOT;

        $this->client->request('POST', '/api/oauth/v2/token', [], [], ['CONTENT_TYPE' => 'application/json'], $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'authentication/new_access_token', Response::HTTP_OK);
    }
}
