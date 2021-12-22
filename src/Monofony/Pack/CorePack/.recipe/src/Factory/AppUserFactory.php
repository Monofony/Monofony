<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Customer\Customer;
use App\Entity\User\AppUser;
use App\Repository\UserRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AppUser>
 *
 * @method static        AppUser|Proxy createOne(array $attributes = [])
 * @method static        AppUser[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static        AppUser|Proxy find(object|array|mixed $criteria)
 * @method static        AppUser|Proxy findOrCreate(array $attributes)
 * @method static        AppUser|Proxy first(string $sortedField = 'id')
 * @method static        AppUser|Proxy last(string $sortedField = 'id')
 * @method static        AppUser|Proxy random(array $attributes = [])
 * @method static        AppUser|Proxy randomOrCreate(array $attributes = [])
 * @method static        AppUser[]|Proxy[] all()
 * @method static        AppUser[]|Proxy[] findBy(array $attributes)
 * @method static        AppUser[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static        AppUser[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static        UserRepository|RepositoryProxy repository()
 * @method AppUser|Proxy create(array|callable $attributes = [])
 */
final class AppUserFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'customer' => null,
            'username' => self::faker()->userName(),
            'email' => self::faker()->email(),
            'first_name' => self::faker()->firstName(),
            'last_name' => self::faker()->lastName(),
            'enabled' => true,
            'password' => 'password123',
            'roles' => [],
        ];
    }

    protected function initialize(): self
    {
        return $this
            ->beforeInstantiate(function (array $attributes): array {
                $customer = $attributes['customer'];

                if (null === $customer) {
                    $customer = new Customer();
                    $customer->setEmail($attributes['email']);
                    $customer->setFirstName($attributes['first_name']);
                    $customer->setLastName($attributes['last_name']);
                }

                unset($attributes['email']);
                unset($attributes['first_name']);
                unset($attributes['last_name']);

                $attributes['customer'] = $customer;

                return $attributes;
            })
        ;
    }

    protected static function getClass(): string
    {
        return AppUser::class;
    }
}
