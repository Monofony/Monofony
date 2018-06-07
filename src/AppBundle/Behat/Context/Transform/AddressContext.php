<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Context\Transform;

use AppBundle\Entity\Address;
use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Webmozart\Assert\Assert;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class AddressContext implements Context
{
    /**
     * @var RepositoryInterface
     */
    private $addressRepository;

    /**
     * ArticleContext constructor.
     *
     * @param RepositoryInterface $addressRepository
     */
    public function __construct(RepositoryInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * @Transform /^address "([^"]+)"$/
     * @Transform :address
     */
    public function getArticleStreet($street)
    {
        /** @var Address $address */
        $address = $this->addressRepository->findOneBy(['street' => $street]);

        Assert::notNull(
            $address,
            sprintf('Address with street "%s" does not exist', $street)
        );

        return $address;
    }
}
