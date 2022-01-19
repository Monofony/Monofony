<?php

declare(strict_types=1);

namespace App\Entity\OAuth;

use App\Entity\User\AppUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;

#[ORM\Entity]
#[ORM\Table(name: 'oauth_refresh_token')]
class RefreshToken extends BaseRefreshToken
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected $id;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(nullable: false)]
    protected $client;

    #[ORM\ManyToOne(targetEntity: AppUser::class)]
    protected $user;
}
