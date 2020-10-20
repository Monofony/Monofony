<?php

declare(strict_types=1);

namespace App\Provider;

use Monofony\Component\Core\Model\Customer\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;

final class CustomerProvider implements CustomerProviderInterface
{
    private $canonicalizer;
    private $customerFactory;
    private $customerRepository;

    public function __construct(
        CanonicalizerInterface $canonicalizer,
        FactoryInterface $customerFactory,
        RepositoryInterface $customerRepository
    ) {
        $this->canonicalizer = $canonicalizer;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
    }

    public function provide(string $email): CustomerInterface
    {
        $emailCanonical = $this->canonicalizer->canonicalize($email);

        /** @var CustomerInterface|null $customer */
        $customer = $this->customerRepository->findOneBy(['emailCanonical' => $emailCanonical]);

        if (null === $customer) {
            /** @var CustomerInterface $customer */
            $customer = $this->customerFactory->createNew();
            $customer->setEmail($email);
        }

        return $customer;
    }
}
