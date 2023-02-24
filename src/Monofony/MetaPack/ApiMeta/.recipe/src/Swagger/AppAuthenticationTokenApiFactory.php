<?php

declare(strict_types=1);

namespace App\Swagger;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use ApiPlatform\OpenApi\OpenApi;
use Monofony\Contracts\Api\Swagger\AppAuthenticationTokenApiFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

final class AppAuthenticationTokenApiFactory implements AppAuthenticationTokenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        $schemas = $openApi->getComponents()->getSchemas();

        $schemas['AppUserToken'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ]);

        $schemas['AppUserCredentials'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'customer@example.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'password',
                ],
            ],
        ]);

        $openApi->getPaths()->addPath('/api/authentication_token', new PathItem(
            ref: 'Authentication token',
            post: new Operation(
                operationId: 'postCredentialsItem',
                tags: ['AppUserToken'],
                responses: [
                    Response::HTTP_OK => [
                        'description' => 'Get JWT token',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/AppUserToken',
                                ],
                            ],
                        ],
                    ],
                ],
                summary: 'Get JWT token to login.',
                requestBody: new RequestBody(
                    description: 'Create new JWT Token',
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/AppUserCredentials',
                            ],
                        ],
                    ]),
                ),
            ),
        ));

        return $openApi;
    }
}
