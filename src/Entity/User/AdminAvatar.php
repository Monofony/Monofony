<?php

/*
 * This file is part of monofony.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Entity\User;

use App\Entity\Media\Image;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_admin_avatar")
 *
 * @Vich\Uploadable
 */
class AdminAvatar extends Image
{
    /**
     * {@inheritdoc}
     *
     * @Vich\UploadableField(mapping="admin_avatar", fileNameProperty="path")
     *
     * @Assert\File(maxSize="6000000", mimeTypes={"image/*"})
     */
    protected $file;
}
