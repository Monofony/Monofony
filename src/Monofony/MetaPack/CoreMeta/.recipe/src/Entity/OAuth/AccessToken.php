<?php

declare(strict_types=1);

namespace App\Entity\OAuth;

use App\Entity\User\AppUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

#[ORM\Entity]
#[ORM\Table(name: 'oauth_access_token')]
class AccessToken extends BaseAccessToken
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
