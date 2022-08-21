<?php

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class LoggerCompilerPass implements CompilerPassInterface {

    public function process(ContainerBuilder $container)
    {
        $ids = $container->findTaggedServiceIds('with_logger');

        foreach ($ids as $id => $data) {
            $definition = $container->getDefinition($id);
            $definition->addMethodCall('setLogger', [new Reference('logger')]);
        }
    }
}