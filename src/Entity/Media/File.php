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

namespace App\Entity\Media;

use App\Entity\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\MappedSuperclass
 */
abstract class File implements ResourceInterface
{
    use IdentifiableTrait;
    use TimestampableTrait;

    protected static $uri = '/media/file';

    /** @var \SplFileInfo|null */
    protected $file;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     *
     * @Serializer\Groups({"Default", "Detailed"})
     */
    protected $path;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getFile(): ?\SplFileInfo
    {
        return $this->file;
    }

    public function setFile(?\SplFileInfo $file): void
    {
        $this->file = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): void
    {
        $this->path = $path;
    }

    public function getWebPath(): ?string
    {
        if (null == $path = $this->path) {
            return null;
        }

        return static::$uri.'/'.$path;
    }
}
