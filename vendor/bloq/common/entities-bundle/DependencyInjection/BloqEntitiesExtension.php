<?php

namespace Bloq\Common\EntitiesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class BloqEntitiesExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader(
	        $container,
	        new FileLocator(__DIR__.'/../Resources/config')
	    );
        $loader->load('services.yml');

        foreach ($config['entities'] as $entityType => $entityConf) {
            foreach ($entityConf as $confName => $confValue) {
                $container->setParameter('entities.'.$entityType.'.'.$confName, $confValue);
            }
        }
    }
}
