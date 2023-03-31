<?php

namespace Imported\AppBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class ImportedAppExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container):void
    {
        $configuration = new Configuration();

       $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter(
            'import_app.config.executor',
            $config['executorConfig']['settings']
        );

        $container->setParameter(
            'import_app.config.message',
            $config['messageConfig']
        );

        $container->setParameter(
            'import_app.config.creation',
            $config['creationConfig']
        );
        $container->setParameter(
            'import_app.mapping.configs',
            $config['mappingConfigs']
        );
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}
