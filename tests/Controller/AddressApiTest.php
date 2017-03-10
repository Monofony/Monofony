<?php

/*
 * This file is part of AppName.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace test\AppBundle\Tests\Controller;

use Lakion\ApiTestCase\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class AddressApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function it_allows_indexing_addresses()
    {
        $this->loadFixturesFromFile('resources/addresses.yml');
        $this->client->request('GET', '/api/addresses/');

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'address/index_response', Response::HTTP_OK);
    }
}
