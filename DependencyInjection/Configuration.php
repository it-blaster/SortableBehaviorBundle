<?php

namespace ItBlaster\SortableBehaviorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $supportedDrivers = array('orm', 'mongodb');

        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sortable_behavior');

        $rootNode
            ->children()
            ->scalarNode('db_driver')
                ->info(sprintf(
                    'These following drivers are supported: %s',
                    implode(', ', $supportedDrivers)
                ))
                ->validate()
                    ->ifNotInArray($supportedDrivers)
                    ->thenInvalid('The driver "%s" is not supported. Please choose one of ('.implode(', ', $supportedDrivers).')')
                ->end()
                ->cannotBeOverwritten()
                ->cannotBeEmpty()
                ->defaultValue('orm')
            ->end()
            ->arrayNode('position_field')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('default')
                        ->defaultValue('position')
                    ->end()
                    ->arrayNode('entities')
                        ->prototype('scalar')->end()
                    ->end()
                ->end()
            ->end()

            ->arrayNode('sortable_groups')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('entities')
                        ->useAttributeAsKey('name')
                        ->prototype('variable')
                        ->end()
                    ->end()
                ->end()
            ->end()

        ;

        return $treeBuilder;
    }
}
