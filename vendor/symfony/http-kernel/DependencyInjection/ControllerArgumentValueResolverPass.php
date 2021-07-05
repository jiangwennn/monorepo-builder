<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MonorepoBuilder20210705\Symfony\Component\HttpKernel\DependencyInjection;

use MonorepoBuilder20210705\Symfony\Component\DependencyInjection\Argument\IteratorArgument;
use MonorepoBuilder20210705\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use MonorepoBuilder20210705\Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use MonorepoBuilder20210705\Symfony\Component\DependencyInjection\ContainerBuilder;
use MonorepoBuilder20210705\Symfony\Component\DependencyInjection\Reference;
use MonorepoBuilder20210705\Symfony\Component\HttpKernel\Controller\ArgumentResolver\TraceableValueResolver;
use MonorepoBuilder20210705\Symfony\Component\Stopwatch\Stopwatch;
/**
 * Gathers and configures the argument value resolvers.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
class ControllerArgumentValueResolverPass implements \MonorepoBuilder20210705\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    use PriorityTaggedServiceTrait;
    private $argumentResolverService;
    private $argumentValueResolverTag;
    private $traceableResolverStopwatch;
    public function __construct(string $argumentResolverService = 'argument_resolver', string $argumentValueResolverTag = 'controller.argument_value_resolver', string $traceableResolverStopwatch = 'debug.stopwatch')
    {
        if (0 < \func_num_args()) {
            trigger_deprecation('symfony/http-kernel', '5.3', 'Configuring "%s" is deprecated.', __CLASS__);
        }
        $this->argumentResolverService = $argumentResolverService;
        $this->argumentValueResolverTag = $argumentValueResolverTag;
        $this->traceableResolverStopwatch = $traceableResolverStopwatch;
    }
    public function process(\MonorepoBuilder20210705\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->argumentResolverService)) {
            return;
        }
        $resolvers = $this->findAndSortTaggedServices($this->argumentValueResolverTag, $container);
        if ($container->getParameter('kernel.debug') && \class_exists(\MonorepoBuilder20210705\Symfony\Component\Stopwatch\Stopwatch::class) && $container->has($this->traceableResolverStopwatch)) {
            foreach ($resolvers as $resolverReference) {
                $id = (string) $resolverReference;
                $container->register("debug.{$id}", \MonorepoBuilder20210705\Symfony\Component\HttpKernel\Controller\ArgumentResolver\TraceableValueResolver::class)->setDecoratedService($id)->setArguments([new \MonorepoBuilder20210705\Symfony\Component\DependencyInjection\Reference("debug.{$id}.inner"), new \MonorepoBuilder20210705\Symfony\Component\DependencyInjection\Reference($this->traceableResolverStopwatch)]);
            }
        }
        $container->getDefinition($this->argumentResolverService)->replaceArgument(1, new \MonorepoBuilder20210705\Symfony\Component\DependencyInjection\Argument\IteratorArgument($resolvers));
    }
}