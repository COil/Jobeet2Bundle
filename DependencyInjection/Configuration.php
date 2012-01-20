<?php

namespace COil\Jobeet2Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Processor;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jobeet2');

//        $rootNode
//            ->children()
//                ->scalarNode('active_days2')->defaultValue(30)->end()
//                ->scalarNode('max_jobs_on_homepage')->defaultValue(10)->end()
//            ->end()
//        ;

        return $treeBuilder;
    }
}