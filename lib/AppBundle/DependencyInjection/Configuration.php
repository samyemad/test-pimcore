<?php

namespace Imported\AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Pimcore\Model\DataObject\Manufacturer;
use Pimcore\Model\DataObject\Car;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('imported_app');
        $treeBuilder->getRootNode()->children()

            ->arrayNode('executorConfig')
            ->children()
            ->arrayNode('settings')
            ->children()
            ->booleanNode('skipFirstRow')->end()
            ->scalarNode('delimiter')->end()
            ->scalarNode('enclosure')->end()
            ->scalarNode('escape')->end()
            ->end()->end()
            ->end()
            ->end() // executorConfig

            ->arrayNode('messageConfig')
            ->children()
            ->integerNode('numOfProcessedRows')->end()
            ->end()
            ->end() // messageConfig

            ->arrayNode('creationConfig')
            ->children()
            ->arrayNode('settings')
            ->children()
            ->scalarNode('pathLocationFolder')->end()
            ->scalarNode('classType')->defaultValue(Car::class)->end()
            ->end()->end()
            ->end()
            ->end() // creationConfig

            ->arrayNode('mappingConfigs')
            ->children()

            ->arrayNode('articleNumber')
            ->children()
            ->integerNode('dataSourceIndex')->end()
            ->scalarNode('type')->defaultValue('simple')->end()
            ->end()->end() // articleNumber

            ->arrayNode('manufacturer')
            ->children()
            ->integerNode('dataSourceIndex')->end()
            ->scalarNode('type')->defaultValue('oneToMany')->end()
            ->scalarNode('targetClass')->defaultValue(Manufacturer::class)->end()
            ->scalarNode('targetProperty')->defaultValue('name')->end()
            ->end()->end() // manufacturer

            ->arrayNode('model')
            ->children()
            ->integerNode('dataSourceIndex')->end()
            ->scalarNode('type')->defaultValue('simple')->end()
            ->end()->end() // model

            ->arrayNode('description')
            ->children()
            ->arrayNode('dataSourceIndex')->integerPrototype()->end()->end()
            ->scalarNode('type')->defaultValue('localized')->end()
            ->end()->end() // description

            ->arrayNode('cylinders')
            ->children()
            ->integerNode('dataSourceIndex')->end()
            ->scalarNode('type')->defaultValue('simple')->end()
            ->end()->end() // cylinders

            ->arrayNode('horsepower')
            ->children()
            ->integerNode('dataSourceIndex')->end()
            ->scalarNode('type')->defaultValue('quantityValue')->end()
            ->end()->end() // horsepower

            ->arrayNode('productionYear')
            ->children()
            ->integerNode('dataSourceIndex')->end()
            ->scalarNode('type')->defaultValue('simple')->end()
            ->end()->end() // productionYear

            ->arrayNode('country')
            ->children()
            ->integerNode('dataSourceIndex')->end()
            ->scalarNode('type')->defaultValue('simple')->end()
            ->end()->end() // country

            ->arrayNode('color')
            ->children()
            ->integerNode('dataSourceIndex')->end()
            ->scalarNode('type')->defaultValue('multiValues')->end()
            ->end()->end() // color


            ->end()
            ->end() // mappingConfig
            ->end()
        ;

        $rootNode = $treeBuilder->getRootNode();

        return $treeBuilder;
    }
}
