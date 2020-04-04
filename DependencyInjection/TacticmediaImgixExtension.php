<?php

namespace Tacticmedia\ImgixBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Imgix\ShardStrategy;

class TacticmediaImgixExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('tacticmedia_imgix.enabled', $config['enabled']);

        if (false === array_key_exists($config['default_source'], $config['sources']) && $config['enabled']) {
            if (empty($config['sources'])) {
                throw new \InvalidArgumentException('No imgix sources were configured');
            } else {
                throw new \InvalidArgumentException('Default source should be one of: ' . implode(', ', array_keys($config['sources'])));
            }
        }

        $container->setParameter('tacticmedia_imgix.default_source', $config['default_source']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $extension = $container->getDefinition('tacticmedia_imgix.twig.url_builder_extension');
        $class = $container->getParameter('tacticmedia_imgix.url_builder.class');

        foreach ($config['sources'] as $name => $source) {
            $domains = $source['domains'];
            $tls = true;
            $key = $source['sign_key'];

            $definition = new Definition($class, [$domains, $tls, $key]);

            $id = sprintf('tacticmedia_imgix.url_builder_%s', $name);

            $container->setDefinition($id, $definition);

            $extension->addMethodCall('addBuilder', [$name, new Reference($id)]);
        }
    }
}
