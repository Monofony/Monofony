<?php

declare(strict_types=1);

namespace App\Entity\OAuth;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use FOS\OAuthServerBundle\Model\ClientInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="oauth_client")
 */
class Client extends BaseClient implements ClientInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * {@inheritdoc}
     */
    public function getPublicId(): string
    {
        return $this->getRandomId();
    }
}
