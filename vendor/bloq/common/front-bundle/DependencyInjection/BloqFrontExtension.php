<?php

namespace Bloq\Common\FrontBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class BloqFrontExtension extends Extension
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

/*        foreach ($config['editorial_contents'] as $editorialContentType => $editorialContentConf) {
            $container->setParameter('editorial_contents.'.$editorialContentType.'.type', $editorialContentType);
            foreach ($editorialContentConf as $confName => $confValue) {
                $container->setParameter('editorial_contents.'.$editorialContentType.'.'.$confName, $confValue);
            }
        }*/
    }
}
