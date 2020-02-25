<?php

declare(strict_types=1);

namespace FileJetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('file_jet');
        $rootNode
            ->children()
                ->scalarNode('storage_id')->isRequired()->end()
                ->scalarNode('api_key')->isRequired()->end()
                ->scalarNode('signature_secret')->defaultNull()->end()
                ->scalarNode('base_url')->defaultNull()->end()
                ->booleanNode('auto_mode')->defaultTrue()->end()
                ->scalarNode('custom_domain')
                    ->defaultNull()
                    ->info('Custom domain to use, without scheme')
                    ->example('cdn.example.com')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
