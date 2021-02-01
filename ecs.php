<?php

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $header = <<<EOM
This file is part of the Monofony package.

(c) Monofony

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOM;

    $services = $containerConfigurator->services();
    $services
        ->set(DeclareStrictTypesFixer::class)
        ->set(HeaderCommentFixer::class)
        ->call('configure', [[
            'header' => $header,
            'location' => 'after_open',
        ]])
        ->set(NoSuperfluousPhpdocTagsFixer::class)
        ->call('configure', [[
            'allow_mixed' => true,
        ]])
    ;

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SETS, [SetList::SYMFONY]);
    $parameters->set(Option::PATHS, [__DIR__.'/src']);
    $parameters->set(Option::SKIP, [
        __DIR__.'/**/*Spec.php',
        __DIR__.'/**/.recipe',
    ]);
};
