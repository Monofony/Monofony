<?php



namespace App\Entity\OAuth;

use FOS\OAuthServerBundle\Entity\ClientManager as BaseClientManager;
use FOS\OAuthServerBundle\Model\ClientInterface;

class ClientManager extends BaseClientManager
{
    /**
     * {@inheritdoc}
     */
    public function findClientByPublicId($publicId): ?ClientInterface
    {
        return $this->findClientBy(['randomId' => $publicId]);
    }
}
