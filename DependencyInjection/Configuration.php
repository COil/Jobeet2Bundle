<?php

namespace COil\Jobeet2Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

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

        //$this->addFixturesSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Declare the fixtures section for the plugin.
     *
     * @param ArrayNodeDefinition $rootNode
     */
    private function addFixturesSection($rootNode)
    {
        // Todo: configutatioj pour parametrer le nombre d'enregistrement par page
        $rootNode
            ->children()
                ->arrayNode('jobs')
                ->children()
                    ->arrayNode('counts')
                        ->children()
                    ->end()
                 ->end()
            ->end()
        ;
    }
}