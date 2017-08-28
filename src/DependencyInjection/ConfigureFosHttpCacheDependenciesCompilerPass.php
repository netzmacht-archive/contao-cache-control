<?php

/**
 * @package    contao-cache-control
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved
 * @filesource
 *
 */

namespace Netzmacht\Contao\CacheControl\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ConfigureFosHttpCacheDependenciesCompilerPass
 *
 * @package Netzmacht\Contao\CacheControl\DependencyInjection
 */
class ConfigureFosHttpCacheDependenciesCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('fos_http_cache.cache_manager')) {
            $definition = $container->getDefinition('netzmacht.contao_cache_control.dca.page');
            $definition->setArgument(0, new Reference('fos_http_cache.cache_manager'));
        }

        if ($container->hasDefinition('fos_http_cache.http.symfony_response_tagger')) {
            $definition = $container->getDefinition('netzmacht.contao_cache_control.listener.page_response_tagger');
            $definition->setArgument(0, new Reference('fos_http_cache.http.symfony_response_tagger'));
        }
    }
}
