<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Behat\Element\Backend;

use FriendsOfBehat\PageObjectExtension\Element\Element;

final class TopBarElement extends Element
{
    public function hasAvatarInMainBar(string $avatarPath): bool
    {
        return strpos($this->getAvatarImagePath(), $avatarPath) !== false;
    }

    public function hasDefaultAvatarInMainBar(): bool
    {
        return strpos($this->getAvatarImagePath(), '//placehold.it/50x50') !== false;
    }

    private function getAvatarImagePath(): string
    {
        $image = $this->getDocument()->find('css', 'img.ui.avatar.image');

        if (null === $image) {
            return '';
        }

        return $image->getAttribute('src');
    }
}
