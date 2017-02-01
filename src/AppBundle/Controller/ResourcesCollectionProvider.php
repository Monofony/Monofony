<?php

/*
 * This file is part of Alceane.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Hateoas\Configuration\Route;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Pagerfanta\Pagerfanta;
use Sluggable\Fixture\Issue1058\Page;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Controller\ResourcesCollectionProviderInterface;
use Sylius\Bundle\ResourceBundle\Controller\ResourcesResolverInterface;
use Sylius\Bundle\ResourceBundle\Grid\View\ResourceGridView;
use Sylius\Component\Resource\Repository\RepositoryInterface;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
final class ResourcesCollectionProvider implements ResourcesCollectionProviderInterface
{
    /**
     * @var ResourcesResolverInterface
     */
    private $resourcesResolver;

    /**
     * @var PagerfantaFactory
     */
    private $pagerfantaRepresentationFactory;

    /**
     * @param ResourcesResolverInterface $resourcesResolver
     * @param PagerfantaFactory $pagerfantaRepresentationFactory
     */
    public function __construct(ResourcesResolverInterface $resourcesResolver, PagerfantaFactory $pagerfantaRepresentationFactory)
    {
        $this->resourcesResolver = $resourcesResolver;
        $this->pagerfantaRepresentationFactory = $pagerfantaRepresentationFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function get(RequestConfiguration $requestConfiguration, RepositoryInterface $repository)
    {
        $resources = $this->resourcesResolver->getResources($requestConfiguration, $repository);

        $paginator = $resources instanceof ResourceGridView ? $resources->getData() : $resources;

        if ($paginator instanceof Pagerfanta) {
            $request = $requestConfiguration->getRequest();
            $paginator->setMaxPerPage($requestConfiguration->getPaginationMaxPerPage());
            $paginator->setCurrentPage($request->query->get('page', 1));

            // This prevents Pagerfanta from querying database from a template
            $paginator->getCurrentPageResults();

            if (!$requestConfiguration->isHtmlRequest()) {
                $route = new Route($request->attributes->get('_route'), array_merge($request->attributes->get('_route_params'), $request->query->all()));

                return $this->pagerfantaRepresentationFactory->createRepresentation($paginator, $route);
            }
        }

        return $resources;
    }
}
