<?php

namespace App\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AppExtension extends AbstractResourceExtension
{
    // You can choose your application name, it will use to prefix the configuration keys in the container (the default value is sylius).
    protected $applicationName = 'app';

    public function load(array $config, ContainerBuilder $container)
    {
    }
}
