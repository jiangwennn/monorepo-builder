<?php

declare (strict_types=1);
namespace MonorepoBuilder20210814;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('MonorepoBuilder20210814\Symplify\ConsolePackageBuilder\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
};
