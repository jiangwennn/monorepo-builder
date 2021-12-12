<?php

declare (strict_types=1);
namespace MonorepoBuilder20211212\Symplify\SymplifyKernel\Contract\Config;

use MonorepoBuilder20211212\Symfony\Component\Config\Loader\LoaderInterface;
use MonorepoBuilder20211212\Symfony\Component\DependencyInjection\ContainerBuilder;
interface LoaderFactoryInterface
{
    public function create(\MonorepoBuilder20211212\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \MonorepoBuilder20211212\Symfony\Component\Config\Loader\LoaderInterface;
}
