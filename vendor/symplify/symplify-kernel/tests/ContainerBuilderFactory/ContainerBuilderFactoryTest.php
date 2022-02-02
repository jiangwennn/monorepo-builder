<?php

declare (strict_types=1);
namespace MonorepoBuilder20220202\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use MonorepoBuilder20220202\PHPUnit\Framework\TestCase;
use MonorepoBuilder20220202\Symplify\SmartFileSystem\SmartFileSystem;
use MonorepoBuilder20220202\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use MonorepoBuilder20220202\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends \MonorepoBuilder20220202\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new \MonorepoBuilder20220202\Symplify\SymplifyKernel\ContainerBuilderFactory(new \MonorepoBuilder20220202\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $container = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $container->has(\MonorepoBuilder20220202\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}