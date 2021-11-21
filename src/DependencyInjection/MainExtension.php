<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class MainExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));

        $loader->load('bus.xml');
        $loader->load('commands.xml');
        $loader->load('controllers.xml');
        $loader->load('dashboard_widgets.xml');
        $loader->load('datatables.xml');
        $loader->load('form_types.xml');
        $loader->load('listeners.xml');
        $loader->load('repositories.xml');
        $loader->load('services.xml');
        $loader->load('specifications.xml');
        $loader->load('subscribers.xml');
        $loader->load('twig_extensions.xml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));

        $loader->load('doctrine.xml');
        $loader->load('twig.xml');
    }
}
