<?php

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector;
use Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector;
use Rector\Config\RectorConfig;
use Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Rector\FuncCall\RemoveDumpDataDeadCodeRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereRelationTypeHintingParameterRector;
use RectorLaravel\Rector\MethodCall\EloquentWhereTypeHintClosureParameterRector;
use RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    // register paths
    //----------------------------------------------------------
    $rectorConfig->paths([
        __DIR__.'/src',
    ]);

    $rectorConfig->parallel(
        processTimeout: 360,
        maxNumberOfProcess: 16,
        jobSize: 20
    );

    $rectorConfig->importNames();

    // cache settings
    //----------------------------------------------------------

    // Ensure file system caching is used instead of in-memory.
    $rectorConfig->cacheClass(FileCacheStorage::class);

    // Specify a path that works locally as well as on CI job runners.
    $rectorConfig->cacheDirectory(__DIR__.'/.rector_cache');

    // skip paths and/or rules
    //----------------------------------------------------------
    $rectorConfig->skip([
        // Rector transforms $foo++ into ++$foo
        // and behind Pint transforms ++$foo into $foo++;
        // so I deactivate, leaving priority to Pint for the moment
        PostIncDecToPreIncDecRector::class,

        // Transforme des faux-positifs, je préfère désactiver ça (PHP 8.1)
        //NullToStrictStringFuncCallArgRector::class,

        // Personally I find reading is more difficult with this syntax, so I disable
        ArraySpreadInsteadOfArrayMergeRector::class,

        // Do not change closure and Arrow Function to Static
        StaticClosureRector::class,
        StaticArrowFunctionRector::class,
    ]);

    $rectorConfig->rules([
        OptionalToNullsafeOperatorRector::class,
        RemoveDumpDataDeadCodeRector::class,
    ]);

    $rectorConfig->sets([
        LaravelSetList::LARAVEL_FACADE_ALIASES_TO_FULL_NAMES,
        SetList::PHP_82,
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        //SetList::CODING_STYLE,
        //SetList::NAMING,
        SetList::TYPE_DECLARATION,
        //SetList::PRIVATIZATION,
        SetList::EARLY_RETURN,
        SetList::INSTANCEOF,
    ]);
};
