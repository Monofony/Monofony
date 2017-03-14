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

use AppBundle\Entity\Address;
use Lakion\ApiTestCase\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class AddressApiTest extends JsonApiTestCase
{
    /**
     * @var array
     */
    private static $authorizedHeaderWithContentType = [
        'HTTP_Authorization' => 'Bearer SampleTokenNjZkNjY2MDEwMTAzMDkxMGE0OTlhYzU3NzYyMTE0ZGQ3ODcyMDAwM2EwMDZjNDI5NDlhMDdlMQ',
        'CONTENT_TYPE' => 'application/json',
    ];

    /**
     * @var array
     */
    private static $authorizedHeaderWithAccept = [
        'HTTP_Authorization' => 'Bearer SampleTokenNjZkNjY2MDEwMTAzMDkxMGE0OTlhYzU3NzYyMTE0ZGQ3ODcyMDAwM2EwMDZjNDI5NDlhMDdlMQ',
        'ACCEPT' => 'application/json',
    ];

    /**
     * @test
     */
    public function it_does_not_allow_to_show_taxon_when_it_does_not_exist()
    {
        $this->loadFixturesFromFile('authentication/api_user.yml');
        $this->loadFixturesFromFile('resources/addresses.yml');

        $this->client->request('GET', '/api/addresses/-1', [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_allows_indexing_addresses()
    {
        $this->loadFixturesFromFile('authentication/api_user.yml');
        $this->loadFixturesFromFile('resources/addresses.yml');
        $this->client->request('GET', '/api/addresses/', [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'address/index_response', Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function it_allows_creating_address()
    {
        $this->loadFixturesFromFile('authentication/api_user.yml');

        $data =
            <<<EOT
                    {
            "street": "2 rue de la Mabilais",
            "postcode": "35000",
            "city": "Rennes"
        }
EOT;

        $this->client->request('POST', '/api/addresses/', [], [], static::$authorizedHeaderWithContentType, $data);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'address/create_response', Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_does_not_allow_delete_address_if_it_does_not_exist()
    {
        $this->loadFixturesFromFile('authentication/api_user.yml');

        $this->client->request('DELETE', '/api/addresses/-1', [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();

        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_allows_delete_address()
    {
        $this->loadFixturesFromFile('authentication/api_user.yml');

        $addresses = $this->loadFixturesFromFile('resources/addresses.yml');
        $address = $addresses['address1'];

        $this->client->request('DELETE', $this->getAddressUrl($address), [], [], static::$authorizedHeaderWithContentType, []);

        $response = $this->client->getResponse();
        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
        $address = $addresses['address1'];

        $this->client->request('GET', $this->getAddressUrl($address), [], [], static::$authorizedHeaderWithAccept);

        $response = $this->client->getResponse();
        $this->assertResponse($response, 'error/not_found_response', Response::HTTP_NOT_FOUND);
    }

    /**
     * @test
     */
    public function it_allows_updating_address()
    {
        $this->loadFixturesFromFile('authentication/api_user.yml');

        $addresses = $this->loadFixturesFromFile('resources/addresses.yml');
        $address = $addresses["address1"];

        $data =
            <<<EOT
                    {
            "street": "16 rue DOM François Plaine",
            "postcode": "35137",
            "city": "Bédée"
        }
EOT;
        $this->client->request('PUT', $this->getAddressUrl($address), [], [], static::$authorizedHeaderWithContentType, $data);
        $response = $this->client->getResponse();

        $this->assertResponseCode($response, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param Address $address
     *
     * @return string
     */
    private function getAddressUrl(Address $address)
    {
        return '/api/addresses/' . $address->getId();
    }
}
