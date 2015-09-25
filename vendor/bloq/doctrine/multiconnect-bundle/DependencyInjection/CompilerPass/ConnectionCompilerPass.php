<?php

namespace Bloq\Doctrine\MulticonnectBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class ConnectionCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $connection = $container
            ->getDefinition('doctrine.dbal.dynamic_connection')
            ->addMethodCall('setSession', [
                new Reference('session')
            ]);
    }
}

