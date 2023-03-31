<?php

namespace Imported\AppBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Imported\AppBundle\Services\Mapping\MappingConfiguration;

class MappingConfigurationPass implements CompilerPassInterface
{
    const MAPPING_CONFIGURATION_TAG = 'importer.mapping_data.configuration_class';

    /**
     * @param ContainerBuilder $container
     * @return void
     */
    public function process(ContainerBuilder $container):void
    {
        $taggedServices = $container->findTaggedServiceIds(self::MAPPING_CONFIGURATION_TAG);
        $mappingConfigurationDataClasses = [];
        if (sizeof($taggedServices)) {
            foreach ($taggedServices as $id => $tags) {
                foreach ($tags as $attributes) {
                    $mappingConfigurationDataClasses[$attributes['type']] = new Reference($id);
                }
            }
        }
        $serviceLocator = $container->getDefinition(MappingConfiguration::class);
        $serviceLocator->setArgument('$mappingConfigurationDataClasses', $mappingConfigurationDataClasses);
    }
}
