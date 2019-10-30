<?php
declare(strict_types=1);

namespace PhpCommons\CQRSBus\DependencyInjection;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Yaml\Yaml;

class CQRSBusExtension extends Extension
{
    private $path = __DIR__.'/../Resources/config';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator($this->path));
        $loader->load('services.yml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        if (!isset($bundles[FrameworkBundle::class])) {
            $config = Yaml::parseFile(sprintf('%s/%s', $this->path, 'messenger.yml'));
            foreach ($container->getExtensions() as $name => $extension) {
                switch ($name) {
                    case 'framework':
                        $container->prependExtensionConfig($name, $config);
                        break;
                }
            }
        }
    }
}