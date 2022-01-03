<?php

declare(strict_types=1);

namespace App\Entity\OAuth;

use App\Entity\User\AppUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;
use FOS\OAuthServerBundle\Model\ClientInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'oauth_refresh_token')]
class RefreshToken extends BaseRefreshToken
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    /**
     * @var ClientInterface
     */
    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected $client;

    /**
     * @var UserInterface
     */
    #[ORM\ManyToOne(targetEntity: AppUser::class)]
    protected $user;
}
