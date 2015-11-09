<?php

namespace Bloq\Common\MultimediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class BloqMultimediaExtension extends Extension
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
        
        $container->setParameter('editor.domain.path', $config['domain_path']);
        $container->setParameter('multimedia.upload.root_dir.rel.path', $config['upload_dir']);
        $container->setParameter('multimedia.images.root_dir.path', $config['images']['root_dir_rel_path']);
        $container->setParameter('multimedia.images.root_dir.url', $config['images']['root_dir_rel_url']);
    }
}
