<?php

declare(strict_types=1);

namespace App\Entity\Media;

interface FileInterface
{
    public function getFile(): ?\SplFileInfo;

    public function setFile(?\SplFileInfo $file): void;

    public function getPath(): ?string;

    public function setPath(?string $path): void;
}
