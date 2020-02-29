<?php


namespace App\Entity\OAuth;

use FOS\OAuthServerBundle\Entity\Client as BaseClient;
use Doctrine\ORM\Mapping as ORM;
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
