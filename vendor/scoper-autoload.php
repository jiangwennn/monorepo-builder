<?php

// scoper-autoload.php @generated by PhpScoper

$loader = require_once __DIR__.'/autoload.php';

// Aliases for the whitelisted classes. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#class-whitelisting
if (!class_exists('ComposerAutoloaderInitcaeedb440ed75f994734e5880b07ccfb', false) && !interface_exists('ComposerAutoloaderInitcaeedb440ed75f994734e5880b07ccfb', false) && !trait_exists('ComposerAutoloaderInitcaeedb440ed75f994734e5880b07ccfb', false)) {
    spl_autoload_call('MonorepoBuilder20210930\ComposerAutoloaderInitcaeedb440ed75f994734e5880b07ccfb');
}
if (!class_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !interface_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false) && !trait_exists('Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator', false)) {
    spl_autoload_call('MonorepoBuilder20210930\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator');
}
if (!class_exists('Normalizer', false) && !interface_exists('Normalizer', false) && !trait_exists('Normalizer', false)) {
    spl_autoload_call('MonorepoBuilder20210930\Normalizer');
}
if (!class_exists('JsonException', false) && !interface_exists('JsonException', false) && !trait_exists('JsonException', false)) {
    spl_autoload_call('MonorepoBuilder20210930\JsonException');
}
if (!class_exists('Attribute', false) && !interface_exists('Attribute', false) && !trait_exists('Attribute', false)) {
    spl_autoload_call('MonorepoBuilder20210930\Attribute');
}
if (!class_exists('Stringable', false) && !interface_exists('Stringable', false) && !trait_exists('Stringable', false)) {
    spl_autoload_call('MonorepoBuilder20210930\Stringable');
}
if (!class_exists('UnhandledMatchError', false) && !interface_exists('UnhandledMatchError', false) && !trait_exists('UnhandledMatchError', false)) {
    spl_autoload_call('MonorepoBuilder20210930\UnhandledMatchError');
}
if (!class_exists('ValueError', false) && !interface_exists('ValueError', false) && !trait_exists('ValueError', false)) {
    spl_autoload_call('MonorepoBuilder20210930\ValueError');
}
if (!class_exists('ReturnTypeWillChange', false) && !interface_exists('ReturnTypeWillChange', false) && !trait_exists('ReturnTypeWillChange', false)) {
    spl_autoload_call('MonorepoBuilder20210930\ReturnTypeWillChange');
}
if (!class_exists('Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection', false) && !interface_exists('Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection', false) && !trait_exists('Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection', false)) {
    spl_autoload_call('MonorepoBuilder20210930\Symplify\ComposerJsonManipulator\ValueObject\ComposerJsonSection');
}

// Functions whitelisting. For more information see:
// https://github.com/humbug/php-scoper/blob/master/README.md#functions-whitelisting
if (!function_exists('resolveConfigFileInfo')) {
    function resolveConfigFileInfo() {
        return \MonorepoBuilder20210930\resolveConfigFileInfo(...func_get_args());
    }
}
if (!function_exists('composerRequirecaeedb440ed75f994734e5880b07ccfb')) {
    function composerRequirecaeedb440ed75f994734e5880b07ccfb() {
        return \MonorepoBuilder20210930\composerRequirecaeedb440ed75f994734e5880b07ccfb(...func_get_args());
    }
}
if (!function_exists('setproctitle')) {
    function setproctitle() {
        return \MonorepoBuilder20210930\setproctitle(...func_get_args());
    }
}
if (!function_exists('array_is_list')) {
    function array_is_list() {
        return \MonorepoBuilder20210930\array_is_list(...func_get_args());
    }
}
if (!function_exists('enum_exists')) {
    function enum_exists() {
        return \MonorepoBuilder20210930\enum_exists(...func_get_args());
    }
}
if (!function_exists('includeIfExists')) {
    function includeIfExists() {
        return \MonorepoBuilder20210930\includeIfExists(...func_get_args());
    }
}
if (!function_exists('dump')) {
    function dump() {
        return \MonorepoBuilder20210930\dump(...func_get_args());
    }
}
if (!function_exists('dd')) {
    function dd() {
        return \MonorepoBuilder20210930\dd(...func_get_args());
    }
}

return $loader;
