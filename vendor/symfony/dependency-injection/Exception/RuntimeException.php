<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MonorepoBuilder202301\Symfony\Component\DependencyInjection\Exception;

/**
 * Base RuntimeException for Dependency Injection component.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
}
