<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Monofony\Bridge\Behat\Client;

use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Monofony\Bridge\Behat\Service\SprintfResponseEscaper;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

final class ResponseChecker implements ResponseCheckerInterface
{
    public function countCollectionItems(Response $response): int
    {
        return count($this->getCollection($response));
    }

    public function countTotalCollectionItems(Response $response): int
    {
        return (int) $this->getResponseContentValue($response, 'hydra:totalItems');
    }

    public function getCollection(Response $response): array
    {
        return $this->getResponseContentValue($response, 'hydra:member');
    }

    public function getCollectionItemsWithValue(Response $response, string $key, string $value): array
    {
        $items = array_filter($this->getCollection($response), fn (array $item): bool => $item[$key] === $value);

        return $items;
    }

    public function getValue(Response $response, string $key)
    {
        return $this->getResponseContentValue($response, $key);
    }

    public function getTranslationValue(Response $response, string $key, ?string $localeCode = 'en_US'): string
    {
        return $this->getResponseContentValue($response, 'translations')[$localeCode][$key] ?? '';
    }

    public function getError(Response $response): string
    {
        if ($this->hasKey($response, 'message')) {
            return $this->getValue($response, 'message');
        }

        return $this->getResponseContentValue($response, 'hydra:description');
    }

    public function isAccepted(Response $response): bool
    {
        return Response::HTTP_ACCEPTED === $response->getStatusCode();
    }

    public function isCreationSuccessful(Response $response): bool
    {
        return Response::HTTP_CREATED === $response->getStatusCode();
    }

    public function isDeletionSuccessful(Response $response): bool
    {
        return Response::HTTP_NO_CONTENT === $response->getStatusCode();
    }

    public function hasAccessDenied(Response $response): bool
    {
        if (!$response instanceof JWTAuthenticationFailureResponse) {
            return false;
        }

        return
            'JWT Token not found' === $response->getMessage() &&
            Response::HTTP_UNAUTHORIZED === $response->getStatusCode();
    }

    public function hasCollection(Response $response): bool
    {
        return $this->hasKey($response, 'hydra:member');
    }

    public function isShowSuccessful(Response $response): bool
    {
        return Response::HTTP_OK === $response->getStatusCode();
    }

    public function isUpdateSuccessful(Response $response): bool
    {
        return Response::HTTP_OK === $response->getStatusCode();
    }

    /** @param string|int $value */
    public function hasValue(Response $response, string $key, $value): bool
    {
        return $this->getResponseContentValue($response, $key) === $value;
    }

    /** @param string|int $value */
    public function hasValueInCollection(Response $response, string $key, $value): bool
    {
        return in_array($value, $this->getResponseContentValue($response, $key), true);
    }

    /** @param string|int $value */
    public function hasItemWithValue(Response $response, string $key, $value): bool
    {
        foreach ($this->getCollection($response) as $resource) {
            if ($resource[$key] === $value) {
                return true;
            }
        }

        return false;
    }

    /** @param string|int $value */
    public function hasSubResourceWithValue(Response $response, string $subResource, string $key, $value): bool
    {
        foreach ($this->getResponseContentValue($response, $subResource) as $resource) {
            if ($resource[$key] === $value) {
                return true;
            }
        }

        return false;
    }

    /** @param string|array $value */
    public function hasItemOnPositionWithValue(Response $response, int $position, string $key, $value): bool
    {
        return $this->getCollection($response)[$position][$key] === $value;
    }

    public function hasItemWithTranslation(Response $response, string $locale, string $key, string $translation): bool
    {
        if (!$this->hasCollection($response)) {
            $resource = $this->getResponseContent($response);

            if (isset($resource['translations'][$locale]) && $resource['translations'][$locale][$key] === $translation) {
                return true;
            }
        }

        foreach ($this->getCollection($response) as $resource) {
            if (isset($resource['translations'][$locale]) && $resource['translations'][$locale][$key] === $translation) {
                return true;
            }
        }

        return false;
    }

    public function hasKey(Response $response, string $key): bool
    {
        $content = json_decode($response->getContent(), true);

        return array_key_exists($key, $content);
    }

    public function hasTranslation(Response $response, string $locale, string $key, string $translation): bool
    {
        $resource = $this->getResponseContent($response);

        return isset($resource['translations'][$locale]) && $resource['translations'][$locale][$key] === $translation;
    }

    public function hasItemWithValues(Response $response, array $parameters): bool
    {
        foreach ($this->getCollection($response) as $item) {
            if ($this->itemHasValues($item, $parameters)) {
                return true;
            }
        }

        return false;
    }

    public function getResponseContent(Response $response): array
    {
        return json_decode($response->getContent(), true);
    }

    public function hasViolationWithMessage(Response $response, string $message, ?string $property = null): bool
    {
        if (!$this->hasKey($response, 'violations')) {
            return false;
        }

        $violations = $this->getResponseContent($response)['violations'];
        foreach ($violations as $violation) {
            if ($violation['message'] === $message && null === $property) {
                return true;
            }

            if ($violation['message'] === $message && null !== $property && $violation['propertyPath'] === $property) {
                return true;
            }
        }

        return false;
    }

    private function getResponseContentValue(Response $response, string $key)
    {
        $content = json_decode($response->getContent(), true);

        Assert::isArray(
            $content,
            SprintfResponseEscaper::provideMessageWithEscapedResponseContent(
                'Content could not be parsed to array.',
                $response,
            ),
        );

        Assert::keyExists(
            $content,
            $key,
            SprintfResponseEscaper::provideMessageWithEscapedResponseContent(
                'Expected \''.$key.'\' not found.',
                $response,
            ),
        );

        return $content[$key];
    }

    private function itemHasValues(array $element, array $parameters): bool
    {
        foreach ($parameters as $key => $value) {
            if ($element[$key] !== $value) {
                return false;
            }
        }

        return true;
    }
}
