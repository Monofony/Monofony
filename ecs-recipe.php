<?php

use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::SYMFONY);

    $services = $containerConfigurator->services();
    $services
        ->set(DeclareStrictTypesFixer::class)
        ->set(OrderedImportsFixer::class)
        ->set(NoUnusedImportsFixer::class)
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
        __DIR__.'/src/Monofony/Pack/AdminPack/.recipe',
        __DIR__.'/src/Monofony/Pack/ApiPack/.recipe',
        __DIR__.'/src/Monofony/Pack/CorePack/.recipe',
        __DIR__.'/src/Monofony/Pack/FrontPack/.recipe',
    ]);
    $parameters->set(Option::SKIP, [
        __DIR__.'/**/*Spec.php',
    ]);

    $parameters->set('skip', [
        VisibilityRequiredFixer::class => ['*Spec.php'],
        PhpUnitTestClassRequiresCoversFixer::class => ['*Test.php'],
        PhpUnitInternalClassFixer::class => ['*Test.php'],
        PhpUnitMethodCasingFixer::class => ['*Test.php'],
    ]);
};
