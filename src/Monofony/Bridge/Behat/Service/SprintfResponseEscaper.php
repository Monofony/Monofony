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

namespace Monofony\Bridge\Behat\Service;

use Symfony\Component\HttpFoundation\Response;

final class SprintfResponseEscaper
{
    public static function provideMessageWithEscapedResponseContent(string $message, Response $response): string
    {
        return sprintf(
            '%s Received response: %s',
            $message,
            str_replace(
                '%',
                '%%',
                json_encode(json_decode($response->getContent(), true), \JSON_PRETTY_PRINT),
            ),
        );
    }
}
