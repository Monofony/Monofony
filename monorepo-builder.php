<?php

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $config): void {
    $config->packageDirectories([
        // default value
        __DIR__ . '/src/Monofony',
    ]);
};
