<?php

namespace Bloq\Common\EditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class BloqEditorExtension extends Extension
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

        foreach ($config['editorial_contents'] as $editorialContentType => $editorialContentConf) {
            foreach ($editorialContentConf as $confName => $confValue) {
                $container->setParameter('editorial_contents.'.$editorialContentType.'.'.$confName, $confValue);
                /*$container->setParameter('editorial_contents.'.$editorialContentType.'.model_class', $editorialContentConf['model_class']);
                $container->setParameter('editorial_contents.'.$editorialContentType.'.manager_class', $editorialContentConf['manager_class']);
	            $container->setParameter('editorial_contents.'.$editorialContentType.'.form_type_class', $editorialContentConf['form_type_class']);
                $container->setParameter('editorial_contents.'.$editorialContentType.'.form_type_name', $editorialContentConf['form_type_name']);
                */
            }
        }
    }
}