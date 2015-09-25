<?php

namespace Bloq\Doctrine\MulticonnectBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MulticonnectBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ConnectionCompilerPass());
    }
}
