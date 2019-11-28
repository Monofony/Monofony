<?php

namespace spec\App\Entity\OAuth;

use App\Entity\OAuth\ClientManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FOS\OAuthServerBundle\Entity\ClientManager as FOSClientManager;
use FOS\OAuthServerBundle\Model\ClientInterface;
use FOS\OAuthServerBundle\Model\ClientManagerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientManagerSpec extends ObjectBehavior
{
    function let(EntityManager $em, EntityRepository $repository, $clientClass = 'Client/Class/String'): void
    {
        $em->getRepository($clientClass)->shouldBeCalled()->willReturn($repository);
        $this->beConstructedWith($em, $clientClass);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ClientManager::class);
    }

    function it_extends_fos_oauth_server_client_manager(): void
    {
        $this->shouldHaveType(FOSClientManager::class);
    }

    function it_implements_fos_oauth_server_client_manager_interface(): void
    {
        $this->shouldImplement(ClientManagerInterface::class);
    }

    function it_finds_client_by_public_id(ClientInterface $client, $repository): void
    {
        $repository->findOneBy(['randomId' => 'random_string'])->willReturn($client);

        $this->findClientByPublicId('random_string')->shouldReturn($client);
    }

    function it_returns_null_if_client_does_not_exist($repository): void
    {
        $repository->findOneBy(['randomId' => 'random_string'])->willReturn(null);

        $this->findClientByPublicId('random_string')->shouldReturn(null);
    }
}
