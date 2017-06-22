<?php
/*
 * This file is part of AppName.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AppBundle\Entity\OAuth;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @author Corentin Nicole <corentin@mobizel.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="oauth_client")
 */
class Client extends BaseClient implements ResourceInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}