<?php

declare (strict_types=1);
namespace MonorepoBuilder20211101\Symplify\PackageBuilder\Contract\HttpKernel;

use MonorepoBuilder20211101\Symfony\Component\HttpKernel\KernelInterface;
use MonorepoBuilder20211101\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \MonorepoBuilder20211101\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
