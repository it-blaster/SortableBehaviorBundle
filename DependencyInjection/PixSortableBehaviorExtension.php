<?php

namespace ItBlaster\SortableBehaviorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Alias;

class SortableBehaviorExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('sortable.behavior.position.field', $config['position_field']);
        $container->setParameter('sortable.behavior.sortable_groups', $config['sortable_groups']);

        $positionHandler = sprintf(
            'sortable_behavior.position.%s',
            $config['db_driver']
        );

        $container->setAlias('sortable_behavior.position', new Alias($positionHandler));
        $container->getAlias('sortable_behavior.position')->setPublic(true);
    }
}
