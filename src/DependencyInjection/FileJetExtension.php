<?php

declare(strict_types=1);

namespace FileJetBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\Kernel;

class FileJetExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processedConfig = $this->processConfiguration($configuration, $configs);

        $container->setParameter('filejet.api_key', $processedConfig['api_key']);
        $container->setParameter('filejet.storage_id', $processedConfig['storage_id']);
        $container->setParameter('filejet.auto_mode', $processedConfig['auto_mode']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load($this->getResource());
    }

    private function getResource(): string
    {
        if (Kernel::MAJOR_VERSION < 3) {
            return 'services-legacy.yml';
        }

        if (Kernel::MAJOR_VERSION === 3 && Kernel::MINOR_VERSION <= 2) {
            return 'services-legacy.yml';
        }

        return 'services-autowire.yml';
    }
}
