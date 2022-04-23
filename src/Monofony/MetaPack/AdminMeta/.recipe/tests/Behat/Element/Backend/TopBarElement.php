<?php

declare(strict_types=1);

namespace App\Tests\Behat\Element\Backend;

use FriendsOfBehat\PageObjectExtension\Element\Element;

final class TopBarElement extends Element
{
    public function hasAvatarInMainBar(string $avatarPath): bool
    {
        return str_contains($this->getAvatarImagePath(), $avatarPath);
    }

    public function hasDefaultAvatarInMainBar(): bool
    {
        return str_contains($this->getAvatarImagePath(), '//placehold.it/50x50');
    }

    private function getAvatarImagePath(): string
    {
        $image = $this->getDocument()->find('css', 'img.ui.avatar.image');

        if (null === $image) {
            return '';
        }

        return (string) $image->getAttribute('src');
    }
}
