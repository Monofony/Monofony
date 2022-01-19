<?php

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::SYMFONY);

    $services = $containerConfigurator->services();
    $services
        ->set(DeclareStrictTypesFixer::class)
        ->set(HeaderCommentFixer::class)
        ->call('configure', [[
            'header' => '',
            'location' => 'after_open',
        ]])
        ->set(NoSuperfluousPhpdocTagsFixer::class)
        ->call('configure', [[
            'allow_mixed' => true,
        ]])
    ;

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/src/Monofony/MetaPack/AdminMeta/.recipe',
        __DIR__ . '/src/Monofony/MetaPack/ApiMeta/.recipe',
        __DIR__ . '/src/Monofony/MetaPack/CoreMeta/.recipe',
        __DIR__ . '/src/Monofony/MetaPack/FrontMeta/.recipe',
    ]);
    $parameters->set(Option::SKIP, [
        __DIR__.'/**/*Spec.php',
    ]);
};
