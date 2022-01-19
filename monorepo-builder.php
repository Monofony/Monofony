<?php

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\MonorepoBuilder\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PACKAGE_DIRECTORIES, [
        __DIR__.'/src',
    ]);

    $parameters->set(Option::DIRECTORIES_TO_REPOSITORIES, [
        // Bridges
        __DIR__.'/src/Monofony/Bridge/Behat' => 'git@github.com:Monofony/BehatBridge.git',
        __DIR__.'/src/Monofony/Bridge/FOSOAuthServer' => 'git@github.com:Monofony/FOSOAuthServerBridge.git',
        __DIR__.'/src/Monofony/Bridge/SyliusUser' => 'git@github.com:Monofony/SyliusUserBridge.git',

        // Bundles
        __DIR__.'/src/Monofony/Bundle/CoreBundle' => 'git@github.com:Monofony/CoreBundle.git',

        // Components
        __DIR__.'/src/Monofony/Component/Admin' => 'git@github.com:Monofony/Admin.git',
        __DIR__.'/src/Monofony/Component/Core' => 'git@github.com:Monofony/Core.git',

        // Contracts
        __DIR__.'/src/Monofony/Contracts/Admin' => 'git@github.com:Monofony/AdminContracts.git',
        __DIR__.'/src/Monofony/Contracts/Api' => 'git@github.com:Monofony/ApiContracts.git',
        __DIR__.'/src/Monofony/Contracts/Core' => 'git@github.com:Monofony/CoreContracts.git',
        __DIR__.'/src/Monofony/Contracts/Front' => 'git@github.com:Monofony/FrontContracts.git',

        // MetaPackages
        __DIR__.'/src/Monofony/MetaPack/AdminMeta' => 'git@github.com:Monofony/AdminMeta.git',
        __DIR__.'/src/Monofony/MetaPack/ApiMeta' => 'git@github.com:Monofony/ApiMeta.git',
        __DIR__.'/src/Monofony/MetaPack/CoreMeta' => 'git@github.com:Monofony/CoreMeta.git',
        __DIR__.'/src/Monofony/MetaPack/FrontMeta' => 'git@github.com:Monofony/FrontMeta.git',

        // Packs
        __DIR__.'/src/Monofony/Pack/AdminPack' => 'git@github.com:Monofony/AdminPack.git',
        __DIR__.'/src/Monofony/Pack/ApiPack' => 'git@github.com:Monofony/ApiPack.git',
        __DIR__.'/src/Monofony/Pack/CorePack' => 'git@github.com:Monofony/CorePack.git',
        __DIR__.'/src/Monofony/Pack/FrontPack' => 'git@github.com:Monofony/FrontPack.git',
        __DIR__.'/src/Monofony/Pack/TestPack' => 'git@github.com:Monofony/TestPack.git',
    ]);
};
