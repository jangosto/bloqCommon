<?php

namespace Bloq\Doctrine\MulticonnectBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Bloq\Doctrine\MulticonnectBundle\DependencyInjection\CompilerPass\ConnectionCompilerPass;

class BloqMulticonnectBundle extends Bundle implements BundleInterface
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ConnectionCompilerPass());
    }
}
