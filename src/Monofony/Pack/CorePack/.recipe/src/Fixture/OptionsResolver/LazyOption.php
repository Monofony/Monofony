<?php

declare(strict_types=1);

namespace App\Fixture\OptionsResolver;

use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\OptionsResolver\Options;
use Webmozart\Assert\Assert;

/**
 * Using the hacky hack to distinct between option which wasn't set
 * and option which was set to empty.
 *
 * Usage:
 *
 *   $optionsResolver
 *     ->setDefault('option', LazyOption::randomOne($repository))
 *     ->setNormalizer('option', LazyOption::findOneBy($repository, 'code'))
 *   ;
 *
 *   Returns:
 *     - null if user explicitly set it (['option' => null])
 *     - random one if user skipped that option ([])
 *     - specific one if user defined that option (['option' => 'CODE'])
 */
final class LazyOption
{
    public static function randomOne(ObjectRepository $repository): \Closure
    {
        return function (Options $options) use ($repository) {
            $objects = $repository->findAll();

            Assert::notEmpty($objects);

            return $objects[array_rand($objects)];
        };
    }

    public static function randomOneOrNull(ObjectRepository $repository, int $chanceOfRandomOne): \Closure
    {
        return function (Options $options) use ($repository, $chanceOfRandomOne) {
            if (mt_rand(1, 100) > $chanceOfRandomOne) {
                return null;
            }

            $objects = $repository->findAll();

            return 0 === count($objects) ? null : $objects[array_rand($objects)];
        };
    }

    public static function randomOnes(ObjectRepository $repository, int $amount): \Closure
    {
        return function (Options $options) use ($repository, $amount) {
            $objects = $repository->findAll();

            $selectedObjects = [];
            for (; $amount > 0 && count($objects) > 0; --$amount) {
                $randomKey = array_rand($objects);

                $selectedObjects[] = $objects[$randomKey];

                unset($objects[$randomKey]);
            }

            return $selectedObjects;
        };
    }

    public static function all(ObjectRepository $repository): \Closure
    {
        return function (Options $options) use ($repository) {
            return $repository->findAll();
        };
    }

    public static function findBy(ObjectRepository $repository, string $field): \Closure
    {
        return function (Options $options, $previousValues) use ($repository, $field) {
            if (null === $previousValues || [] === $previousValues) {
                return $previousValues;
            }

            Assert::isArray($previousValues);

            $resources = [];
            foreach ($previousValues as $previousValue) {
                if (is_object($previousValue)) {
                    $resources[] = $previousValue;
                } else {
                    $resources[] = $repository->findOneBy([$field => $previousValue]);
                }
            }

            return $resources;
        };
    }

    public static function findOneBy(ObjectRepository $repository, string $field): \Closure
    {
        return function (Options $options, $previousValue) use ($repository, $field) {
            if (null === $previousValue || [] === $previousValue) {
                return $previousValue;
            }

            if (is_object($previousValue)) {
                return $previousValue;
            } else {
                return $repository->findOneBy([$field => $previousValue]);
            }
        };
    }
}
