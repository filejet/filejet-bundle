<?php

declare(strict_types=1);

namespace FileJetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('file_jet');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('file_jet');
        }

        $rootNode
            ->children()
            ->scalarNode('lambda_controller_function_name')->isRequired()->end()
            ->scalarNode('lambda_client')->isRequired()->end()
            ->scalarNode('custom_domain')
                ->isRequired()
                ->info('Custom domain to use, without scheme')
                ->example('cdn.example.com')
            ->end()
            ->scalarNode('signature_secret')->defaultNull()->end()
            ->scalarNode('base_url')->defaultNull()->end()
            ->booleanNode('auto_mode')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }
}
