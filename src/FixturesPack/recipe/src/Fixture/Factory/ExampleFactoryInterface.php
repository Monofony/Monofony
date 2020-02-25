<?php



namespace App\Fixture\Factory;

interface ExampleFactoryInterface
{
    /**
     * @param array $options
     *
     * @return object
     */
    public function create(array $options = []);
}
